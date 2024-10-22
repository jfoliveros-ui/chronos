<?php
namespace App\Services;

trait ScheduleService {

    /**
     * Función para calcular el corte
     * @param Array $requestData
     * @return String
     */
    public function calculateCut($requestData){
        // Inicio de carga de información para las horas
        $hoursList = date('m', strtotime($requestData['date']));

        if ($hoursList >= 1 && $hoursList <= 6) {
            return '1';
        } else {
            return '2';
        }
    }
}