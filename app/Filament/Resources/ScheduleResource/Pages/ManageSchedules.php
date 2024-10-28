<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Helpers\Helper;
use App\Models\CosumedHours;
use App\Models\Parameter;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Services\ScheduleService;
use ErrorException;
use Filament\Notifications\Actions\Action;
use Filament\Actions;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ManageSchedules extends ManageRecords
{

    use ScheduleService;

    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Asignar Horario')
                ->mutateFormDataUsing(function ($data, $action) {
                    // Extraer todos los datos del formulario
                    $cetap = $data['cetap'];  // Extraer el valor de centro de tutoría
                    $semestre = $data['semester'];  // Extraer el valor de semestre
                    $subject = $data['subject'];  // Extraer el valor de la asignatura
                    $teacherId = $data['teacher_id']; // Extraer el valor de Docente
                    $working_day = $data['working_day'];  // Extraer el valor de Jornada
                    $mode = $data['mode'];  // Extraer el valor de Modalidad
                    $date = $data['dates'];  // Extraer el valor de Fechas o fecha

                    // Variable para rastrear si hay algún conflicto
                    $hasConflict = false;

                    // Iterar sobre las fechas seleccionadas
                    foreach ($date as $dateEntry) {
                        $dates = $dateEntry['date']; // Extraer el valor de Fecha

                        // Buscar todos los registros con el mismo teacher_id y date
                        $existingSchedules = Schedule::where('teacher_id', $teacherId)
                            ->where('date', $dates)
                            ->get();  // Obtener una colección de todos los registros que coinciden

                        // Buscar todos los registros con el mismo cetap y date
                        $existingCetap = Schedule::where('cetap', $cetap)
                            ->where('date', $dates)
                            ->where('working_day', $working_day)
                            ->where('semester', $semestre)
                            ->get();  // Ob tener una colección de todos los registros que coinciden

                        // Crear arrays para almacenar todos los modos y días existentes
                        $existingModes = []; // Guarda los modos del programa
                        $existingDays = []; // Guardar las jornadas del programa
                        $existingCetaps = []; // Guardar los centros de tutoria del programa

                        if (!$existingCetap->isNotEmpty()) {
                           
                            // Si existen asignaciones previas ($existingSchedules no está vacío)
                            if ($existingSchedules->isNotEmpty()) {
                                // Iterar sobre todos los horarios existentes y guardar los modos y días en arrays
                                foreach ($existingSchedules as $existingSchedule) {
                                    $existingModes[] = $existingSchedule->mode;   // Guardar cada modo en el array
                                    $existingDays[] = $existingSchedule->working_day; // Guardar cada jornada en el array
                                    $existingCetaps[] = $existingSchedule->cetap; // Guardar cada cetap en el array
                                }
                                // Llamar a la función de validación
                                if (!Helper::validarConflictos($mode, $cetap, $existingModes, $working_day, $existingDays, $existingCetaps, $existingSchedule, $action)) {
                                    $hasConflict = true;
                                    continue; // Romper el bucle si hay conflicto
                                }
                            }
                        }
                    }
                   
                    try{
                        DB::beginTransaction();
                        $scheduleSaveArray = [];

                        //REalizar validación antes de guardar
                        $validate = $this->validateExistShedule($data);

                        
                        if($validate || $hasConflict){
                            foreach ($date as $dateEntry) {
                                $scheduleCreate = null;
                                //crear datos para almacenar como schedule
                                $dataSchedule = [
                                    'teacher_id' => $teacherId,
                                    'date' => $dateEntry['date'],
                                    'working_day' => $working_day,
                                    'cetap' => $cetap,
                                    'mode' => $mode,
                                    'subject' => $subject,
                                    'semester' => $semestre,
                                ];
    
                                
    
                                if($working_day == "Fin de Semana"){
                                    // Guardar un registro por cada fecha
                                    $scheduleCreate = $this->CreateJornadeFinOworkingDay($dataSchedule);
                                    $scheduleSaveArray[] = $scheduleCreate;
                                } else {
                                    // Guardar un registro por cada fecha
                                    $scheduleCreate = $this->createSchedule($dataSchedule);
                                    $scheduleSaveArray[] = $scheduleCreate;
                                }
    
                            }
    
                            if (in_array(null, $scheduleSaveArray, true)) {
                                DB::rollback();
                                $action->halt();
                            } else {
                                $body = "";
                                
                                foreach($scheduleSaveArray as $sheduleSave){

                                    if(is_array($sheduleSave)){
                                        foreach($sheduleSave as $sheduleS){
                                            if(@$sheduleS->subject && @$sheduleS->mode && @$sheduleS->date && @$sheduleS->working_day){
                                                $body .= "<br> - Se ha asignado la asignatura " . $sheduleS->subject .
                                                " con modalidad " . $sheduleS->mode . " el día " . $sheduleS->date . " en la jornada " . $sheduleS->working_day . ".";
                                            }  
                                        }
                                    } else {
                                        if(@$sheduleSave->subject && @$sheduleSave->mode && @$sheduleSave->date && @$sheduleSave->working_day){
                                            $body .= "<br> - Se ha asignado la asignatura " . $sheduleSave->subject .
                                            " con modalidad " . $sheduleSave->mode . " el día " . $sheduleSave->date . " en la jornada " . $sheduleSave->working_day . ".";
                                        }  
                                    }
                                }
                                $this->notificationSave($body);

                                DB::commit();
                            }
                        } else {
                            //detiene el proceso para que no se cierre el formulario
                            $action->halt();
                        }
                        

                    } catch (ErrorException $e){
                        DB::rollback(); 

                        // Notificación o mensaje si hay conflicto
                        Notification::make()
                            ->title('Conflicto de Horario')
                            ->icon('icon-Alerta')
                            ->actions([
                                Action::make('Ver Calendario')
                                    ->button()
                                    ->url(route('filament.admin.pages.calendar')) // Aquí defines la ruta o recurso
                                    ->openUrlInNewTab(true) // Redirige otra pestaña
                            ])
                            ->danger()
                            ->persistent()
                            ->send();
                       
                        //detiene el proceso para que no se cierre el formulario
                        $action->halt();
                    }
                   
                   
                    //se envia la accion de cancelar para que no guarde los datos ya que se realizarón los cambios
                    $action->cancel();
                })
        ];
    }
}
