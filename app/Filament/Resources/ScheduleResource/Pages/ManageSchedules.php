<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use App\Helpers\Helper;
use App\Models\Schedule;
use Carbon\Carbon;
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
                    $conflictDetected = false; // Indicador para verificar si hay conflictos

                    // Iterar sobre las fechas seleccionadas
                    foreach ($data['dates'] as $dateEntry) {
                        $date = $dateEntry['date'];

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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
                                    }
                                    // Validar los días según Fin de Semana, Viernes - Sábado, Sábado - Domingo

                                    if ($day == 'Fin de Semana') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && ($this->checkConflict($data, $date, 'Mañana') || $this->checkConflict($data, $date, 'Tarde'))) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Viernes - Sábado') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Sábado - Domingo') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Tarde')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
                                    }
                                    // Validar los días según Fin de Semana, Viernes - Sábado, Sábado - Domingo
                                    if ($day == 'Fin de Semana') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && ($this->checkConflict($data, $date, 'Mañana') || $this->checkConflict($data, $date, 'Tarde'))) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Viernes - Sábado') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Sábado - Domingo') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Tarde')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
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

                                        // Marcar conflicto
                                        $conflictDetected = true;
                                        break;
                                    }
                                    // Validar los días según Fin de Semana, Viernes - Sábado, Sábado - Domingo
                                    if ($day == 'Fin de Semana') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && ($this->checkConflict($data, $date, 'Mañana') || $this->checkConflict($data, $date, 'Tarde'))) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Viernes - Sábado') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '5' && $this->checkConflict($data, $date, 'Noche')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    } elseif ($day == 'Sábado - Domingo') {
                                        foreach ($data['dates'] as $date) {
                                            $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                            $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                            $date = $dateEntry['date'];
                                            if ($dayOfWeek == '6' && $this->checkConflict($data, $date, 'Tarde')) {
                                                $conflictDetected = true;
                                            } elseif ($dayOfWeek == '0' && $this->checkConflict($data, $date, 'Mañana')) {
                                                $conflictDetected = true;
                                            }
                                        }
                                    }
                                    break;
                                default:
                                    break;
                            }
                            // Si se detecta un conflicto, detener el proceso
                            if ($conflictDetected) {
                                $action->halt(); // Detiene la acción y no guarda nada
                                return;
                            }
                        }
                        // Si no hay conflictos, guardar todas las fechas en la base de datos
                        switch ($day) {
                            case 'Mañana':
                            case 'Tarde':
                            case 'Noche':
                                // Guardar directamente según el valor del día
                                Schedule::create([
                                    'teacher_id' => $teacherId,
                                    'date' => $date,
                                    'working_day' => $day,
                                    'cetap' => $cetap,
                                    'mode' => $mode,
                                    'subject' => $asignature,
                                    'semester' => $semestre,
                                ]);
                                break;

                            case 'Fin de Semana':
                                foreach ($data['dates'] as $dateEntry) {
                                    $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                    $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                    $date = $dateEntry['date'];
                                    if ($dayOfWeek == '5') {
                                        $schedule = $this->createSchedule($data, $date, 'Noche');
                                        $schedule->save();
                                    } elseif ($dayOfWeek == '6') {
                                        $scheduleMorning = $this->createSchedule($data, $date, 'Mañana');
                                        $scheduleAfternoon = $this->createSchedule($data, $date, 'Tarde');
                                        $scheduleMorning->save();
                                        $scheduleAfternoon->save();
                                    } elseif ($dayOfWeek == '0') {
                                        $schedule = $this->createSchedule($data, $date, 'Mañana');
                                        $schedule->save();
                                    }
                                }
                                break;

                            case 'Viernes - Sábado':
                                foreach ($data['dates'] as $date) {
                                    $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                    $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                    $date = $dateEntry['date'];
                                    if ($dayOfWeek == '5') {
                                        $schedule = $this->createSchedule($data, $date, 'Noche');
                                        $schedule->save();
                                    } elseif ($dayOfWeek == '6') {
                                        $schedule = $this->createSchedule($data, $date, 'Mañana');
                                        $schedule->save();
                                    }
                                }
                                break;

                            case 'Sábado - Domingo':
                                foreach ($data['dates'] as $date) {
                                    $dates = Carbon::parse($dateEntry['date']); // Parsear la fecha
                                    $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
                                    $date = $dateEntry['date'];
                                    if ($dayOfWeek == '6') {
                                        $schedule = $this->createSchedule($data, $date, 'Tarde');
                                        $schedule->save();
                                    } elseif ($dayOfWeek == '0') {
                                        $schedule = $this->createSchedule($data, $date, 'Mañana');
                                        $schedule->save();
                                    }
                                }
                                break;

                            default:
                                break;
                        }
                    }
                    // Si no hay conflictos, devolver los datos para continuar con el proceso de creación
                    $action->cancel();
                })
        ];
    }

    // Método auxiliar para verificar si existe un conflicto
    protected function checkConflict($data, $date, $workingDay)
    {
        // Lógica de validación para evitar conflictos
        $existingSchedule = Schedule::where('teacher_id', $data['teacher_id'])
            ->where('date', $date)
            ->where('working_day', $workingDay)
            ->first();

        if ($existingSchedule) {
            Notification::make()
                ->title('Cruce de Horarios')
                ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                    " el día " . $existingSchedule->date . " en la jornada " . $existingSchedule->working_day . ".")
                ->danger()
                ->persistent()
                ->send();

            return true; // Conflicto detectado
        }
    }
    // Método auxiliar para crear el horario
    protected function createSchedule($data, $date, $workingDay)
    {

        return Schedule::create([
            'teacher_id' => $data['teacher_id'],
            'date' => $date,
            'working_day' => $workingDay,
            'cetap' => $data['cetap'],
            'mode' => $data['mode'],
            'subject' => $data['subject'],
            'semester' => $data['semester'],
        ]);
    }
}
