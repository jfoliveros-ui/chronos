<?php

namespace App\Helpers;

use App\Models\Schedule;
use App\Models\Parameter;
use Filament\Notifications\Notification;
use PHPUnit\Framework\MockObject\Rule\Parameters;

class Helper
{
    public static function validarConflictos($mode, $cetap, $existingModes, $working_day, $existingworking_days, $existingCetaps, $existingSchedule, $action = null)
    {
        // Utilizar un switch para manejar los casos de modo
        switch ($mode) {
            case 'Presencial':
                // Validar si ya existe un modo 'Presencial' en los modos existentes y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->icon('icon-Alert_Box')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->title('Cruce de Horarios')
                        ->icon('icon-Alert_Box')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }

                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Presencial' con la misma fecha y working_day
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }
                break;

            case 'Virtual':
                // Validar si ya existe un modo 'Presencial' y se intenta asignar 'Virtual' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();
                    return false; // Hay conflicto
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Virtual' con la misma fecha, working_day y centro de tutoria
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }
                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha, working_day y centro de tutoria
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }
                break;

            case 'Hibrida':
                // Validar si ya existe un modo 'Presencial' y se intenta asignar 'hibrida' con la misma fecha y working_day
                if (in_array('Presencial', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }

                // Validar si ya existe un modo 'Hibrida' y se intenta asignar 'Hibrida' con la misma fecha y working_day
                if (in_array('Hibrida', $existingModes) && (in_array($working_day, $existingworking_days))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }

                // Validar si ya existe un modo 'Virtual' y se intenta asignar 'Hibrida' con la misma fecha, working_day y centro de tutoria
                if (in_array('Virtual', $existingModes) && (in_array($working_day, $existingworking_days)) && (in_array($cetap, $existingCetaps))) {
                    Notification::make()
                        ->icon('icon-Alert_Box')
                        ->title('Cruce de Horarios')
                        ->body("El profesor ya tiene asignada la asignatura " . $existingSchedule->subject .
                            " con modalidad " . $existingSchedule->mode . " el día " . $existingSchedule->date . " en la Jornada  " . $existingSchedule->working_day . ".")
                        ->danger()
                        ->persistent()
                        ->send();

                    return false; // Hay conflicto
                }
                break;
            default:
                break;
        }
        return true;
    }

    /*public static function calcularHoras($requestData)
    {
        // Inicio de carga de información para las horas
        $hoursList = date('m', strtotime($requestData['date']));
        $yearList = date('Y', strtotime($requestData['date']));

        if ($hoursList >= 1 && $hoursList <= 6) {
            $cut = '1';
        } else {
            $cut = '2';
        }

        // Obtener información del profesor
        $infoTeacher = DB::table('persons')
            ->select('categorie', 'pensioner')
            ->where('id', $requestData['teacher'])
            ->first();

        // Obtener valor de la hora según categoría
        $valueHour = Parameter::where('value', $infoTeacher->categorie)->first();

        // Inicializar datos de horas consumidas
        $consumedHour = [
            'schedules_id' => $requestData['idSchedule'] ?? null,
            'consumed_hours' => 4,
            'cut' => $cut,
            'year' => $yearList,
            'categorie' => $infoTeacher->categorie,
            'resolution' => $requestData['resolution'],
            'value_hour' => $valueHour->additional_value
        ];

        // Calcular si es pensionado
        if ($infoTeacher->pensioner == "Si") {
            $pensioner = Parameter::where('parameter', 'PENSIONADO')->first();
            $consumedHour['value_pensioner'] = $pensioner->value;
        } else {
            $consumedHour['value_pensioner'] = 0;
        }

        // Calcula el valor total de las horas
        $subtotal = intval($consumedHour['value_hour']) * intval($consumedHour['consumed_hours']);
        $total = (($subtotal * $consumedHour['value_pensioner']) / 100) + $subtotal;
        $consumedHour['value_total'] = $total;

        // Retorna el arreglo de horas consumidas calculadas
        return $consumedHour;
    }*/
}
