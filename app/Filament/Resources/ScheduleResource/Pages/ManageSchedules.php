<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
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
                    $asignature = $data['subject'];  // Extraer el valor de la asignatura
                    $teacherId = $data['teacher_id']; // Extraer el valor de Docente
                    $day = $data['working_day'];  // Extraer el valor de Jornada
                    $mode = $data['mode'];  // Extraer el valor de Modalidad

                    // Iterar sobre las fechas seleccionadas
                    foreach ($data['dates'] as $dateEntry) {
                        $date = $dateEntry['date']; // Extraer el valor de Fecha

                        // Buscar todos los registros con el mismo teacher_id y date
                        $existingSchedules = Schedule::where('teacher_id', $teacherId)
                            ->where('date', $date)
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

                            // Utilizar un switch para manejar los casos de modo
                            switch ($data['mode']) {
                                case 'Presencial':
                                    // Validar si ya existe un modo 'Presencial' en los modos existentes y se intenta asignar 'Presencial' con la misma fecha y jornada
                                    if (in_array('Presencial', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }

                                    // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Presencial' con la misma fecha y jornada
                                    if (in_array('Virtual', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }

                                    // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Presencial' con la misma fecha y jornada
                                    if (in_array('Hibrida', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }
                                    break;

                                case 'Virtual':
                                    // Validar si ya existe un modo 'Presencial' y se intenta asignar 'Virtual' con la misma fecha y jornada
                                    if (in_array('Presencial', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }

                                    // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Virtual' con la misma fecha, jornada y centro de tutoria
                                    if (in_array('Virtual', $existingModes) && (in_array($day, $existingDays)) && (in_array($cetap, $existingCetaps))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }
                                    // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha, jornada y centro de tutoria
                                    if (in_array('Hibrida', $existingModes) && (in_array($day, $existingDays)) && (in_array($cetap, $existingCetaps))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }
                                    break;

                                case 'Hibrida':
                                    // Validar si ya existe un modo 'Presencial' y se intenta asignar 'hibrida' con la misma fecha y jornada
                                    if (in_array('Presencial', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }

                                    // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha y jornada
                                    if (in_array('Hibrida', $existingModes) && (in_array($day, $existingDays))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }

                                    // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Hibrida' con la misma fecha, jornada y centro de tutoria
                                    if (in_array('Virtual', $existingModes) && (in_array($day, $existingDays)) && (in_array($cetap, $existingCetaps))) {
                                        Notification::make()
                                            ->title('Cruce de Horarios')
                                            ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                                                " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                                            ->danger()
                                            ->persistent()
                                            ->send();

                                        // Detener el proceso de creación
                                        $action->halt();
                                    }
                                    break;
                                default:
                                    break;
                            }
                        }
                        // Si no hay conflictos, guardar un registro por cada fecha
                        Schedule::create([
                            'teacher_id' => $teacherId,
                            'date' => $date,
                            'working_day' => $day,
                            'cetap' => $cetap,
                            'mode' => $mode,
                            'subject' => $asignature,
                            'semester' => $semestre,
                        ]);
                        Notification::make()
                            ->title('Asignación de Horarios')
                            ->body("Se ha asignada la asignatura " . $asignature .
                                " con modalidad " . $mode . " el día " . $date . " en la jornada " . $day . ".")
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
