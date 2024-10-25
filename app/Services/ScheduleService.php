<?php
namespace App\Services;

use App\Models\CosumedHours;
use App\Models\Parameter;
use App\Models\Schedule;
use App\Models\Teacher;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

trait ScheduleService {

    /**
     * Función para calcular el corte
     * @param Array $requestData
     * @return String
     */
    public function calculateCut($date){
        // Inicio de carga de información para las horas
        $hoursList = date('m', strtotime($date));

        if ($hoursList >= 1 && $hoursList <= 6) {
            return '1';
        } else {
            return '2';
        }
    }


    /**
     * Función para crear la notificación del guardado
     * @param Object
     */
    public function notificationSave($schedule){
        Notification::make()
        ->title('Asignación de Horarios')
        ->body("Se ha asignado la asignatura " . $schedule->subject .
            " con modalidad " . $schedule->mode . " el día " . $schedule->dates . " en la jornada " . $schedule->working_day . ".")
        ->info()
        ->send();
    }

    /**
     * Función para crear la notificación del guardado
     * @param Object
     */
    public function notificationSaveValidation($schedule){
        Notification::make()
        ->title('Error de validación')
        ->body("Asignatura ya fue asignada " . $schedule->subject .
            " con modalidad " . $schedule->mode . " el día " . $schedule->date . " en la jornada " . $schedule->working_day . ".")
        ->danger()
        ->persistent()
        ->send();
    }

    /**
     * Función para validar si es pensionado
     * @param String
     * @return int
     */
    public function validateIfPensioner($teacherPensioner){
        if ($teacherPensioner == "Si") {
            $pensioner = Parameter::where('parameter', 'PENSIONADO')->first();
            return $pensioner->value;
        } 

        return 0;
    }

    /**
     * Función para crear asignación de horario si es fin de semana
     * @param Array
     * @return Array
     */
    public function CreateJornadeFinOworkingDay($data){

        $scheduleSaveArray = [];
        $dates = Carbon::parse($data['date']); // Parsear la fecha
        $dayOfWeek = $dates->dayOfWeek; // Obtener el día de la semana (0=Domingo, 5=Viernes, 6=Sábado)
        //dd($dayOfWeek);
        Log::notice('DayOfWeek', [$dayOfWeek]);
        if ($dayOfWeek == '5') {
            $data['working_day'] = 'Noche';
            $scheduleSaveArray[] = $this->createSchedule($data);

            //Sabado
            $data['date'] = $dates->addDay(); // Sumar un día
            $data['working_day'] = 'Mañana';
            $scheduleSaveArray[] = $this->createSchedule($data);

            $data['working_day'] = 'Tarde';
            $scheduleSaveArray[] = $this->createSchedule($data);

            //Domingo
            $data['date'] = $dates->addDay(); // Sumar un día
            $data['working_day'] = 'Mañana';
            $scheduleSaveArray[] = $this->createSchedule($data);
        } /*elseif ($dayOfWeek == '6') {
            $this->createSchedule($data, 'Mañana');
            $this->createSchedule($data, 'Tarde');
        } elseif ($dayOfWeek == '0') {
            $this->createSchedule($data, 'Mañana');
        }*/


        Log::notice('Creado Schedule fin de semana', [$scheduleSaveArray]);
        if (in_array(null, $scheduleSaveArray, true)) {
            return null;
        } else {
            return $scheduleSaveArray;
        }
        
    }

   

    /**
     * Función para almacenar la asignación de horario en base de datos
     * @param Array
     * @param String null
     */
    public function createSchedule($data)
    {
        //Validar si existe el mismo teacher y fecha asignado con anterioridad
        $existingSchedules = Schedule::where('teacher_id', $data['teacher_id'])
                            ->where('date', $data['date'])
                            ->where('working_day', $data['working_day'])
                            ->first();

        if($existingSchedules){
            $this->notificationSaveValidation((object) $data);
            return null;
        }

        $scheduleCreate = Schedule::create([
            'teacher_id' => $data['teacher_id'],
            'date' => $data['date'],
            'working_day' => $data['working_day'],
            'cetap' => $data['cetap'],
            'mode' => $data['mode'],
            'subject' => $data['subject'],
            'semester' => $data['semester'],
        ]);

        if($scheduleCreate){
            $this->createConsumHours($scheduleCreate, $data);
            $this->notificationSave($scheduleCreate);
        }

        return $scheduleCreate;

    }

    public function createConsumHours($scheduleCreate, $dataSchedule){
        if($scheduleCreate){
            $cut = $this->calculateCut($dataSchedule['date']);
            $yearList = date('Y', strtotime($dataSchedule['date']));

            // Obtener información del profesor
            $infoTeacher = Teacher::select('categorie', 'pensioner')
            ->where('id', $dataSchedule['teacher_id'])
            ->first();

            // Obtener valor de la hora según categoría
            $valueHour = Parameter::where('value', $infoTeacher->categorie)->first();

            // Inicializar datos de horas consumidas
            $consumedHour = [
                'schedules_id' => $scheduleCreate->id ?? null,
                'consumed_hours' => 4,
                'cut' => $cut,
                'year' => $yearList,
                'categorie' => $infoTeacher->categorie,
                'resolution' => 'LLL',
                'value_hour' => $valueHour->additional_value
            ];

            // Calcular si es pensionado
            $consumedHour['value_pensioner'] = $this->validateIfPensioner($infoTeacher->pensioner);

            // Calcula el valor total de las horas
            $subtotal = intval($consumedHour['value_hour']) * intval($consumedHour['consumed_hours']);
            $total = (($subtotal * $consumedHour['value_pensioner']) / 100) + $subtotal;
            $consumedHour['value_total'] = $total;

            Log::notice('consumedHour', [$consumedHour]);

            return CosumedHours::create($consumedHour);

        }
    }
}