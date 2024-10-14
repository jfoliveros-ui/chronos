<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Helpers\Helper;
use App\Models\Schedule;
use Filament\Actions;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageSchedules extends ManageRecords
{
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

                    // Iterar sobre las fechas seleccionadas
                    foreach ($date as $dateEntry) {
                        $dates = $dateEntry['date']; // Extraer el valor de Fecha

                        // Buscar todos los registros con el mismo teacher_id y date
                        $existingSchedules = Schedule::where('teacher_id', $teacherId)
                            ->where('date', $dates)
                            ->get();  // Obtener una colección de todos los registros que coinciden

                        // Crear arrays para almacenar todos los modos y días existentes
                        $existingModes = []; // Guarda los modos del programa
                        $existingDays = []; // Guardar las jornadas del programa
                        $existingCetaps = []; // Guardar los centros de tutoria del programa

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
                                continue;
                            }
                        }
                        // Si no hay conflictos, guardar un registro por cada fecha
                        Schedule::create([
                            'teacher_id' => $teacherId,
                            'date' => $dates,
                            'working_day' => $working_day,
                            'cetap' => $cetap,
                            'mode' => $mode,
                            'subject' => $subject,
                            'semester' => $semestre,
                        ]);
                        Notification::make()
                            ->title('Asignación de Horarios')
                            ->body("Se ha asignada la asignatura " . $subject .
                                " con modalidad " . $mode . " el día " . $dates . " en la jornada " . $working_day . ".")
                            ->info()
                            ->persistent()
                            ->send();
                    }
                    // Si no hay conflictos, devolver los datos para continuar con el proceso de creación
                    $action->cancel();
                })
        ];
    }
}
