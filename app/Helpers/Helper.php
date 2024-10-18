<?php

namespace App\Helpers;

use App\Models\Schedule;
use Filament\Notifications\Notification;

class Helper
{
    public static function validarConflictos($mode, $cetap, $existingModes, $working_day, $existingworking_days, $existingCetaps, $existingSchedule, $action)
    {
        // Utilizar un switch para manejar los casos de modo
        switch ($mode) {
            case 'Presencial':
                // Validar si ya existe un modo 'Presencial' en los modos existentes y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                        return true; // Conflicto detectado
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }

                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }
                break;

            case 'Virtual':
                // Validar si ya existe un modo 'Presencial' y se intenta asignar 'Virtual' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();
                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Virtual' con la misma fecha, working_day y centro de tutoria
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }
                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha, working_day y centro de tutoria
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }
                break;

            case 'Hibrida':
                // Validar si ya existe un modo 'Presencial' y se intenta asignar 'hibrida' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }

                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha y working_day
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Hibrida' con la misma fecha, working_day y centro de tutoria
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    // Detener el proceso de creación
                    return true; // Conflicto detectado
                }
                break;
            default:
                break;
        }
        return true;
    }
}
