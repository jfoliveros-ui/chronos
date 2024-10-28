<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Models\CosumedHours;
use App\Models\Parameter;
use App\Models\Schedule;
use App\Models\Teacher;
use Filament\Notifications\Actions\Action;
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
    public function notificationSave($body){
        Notification::make()
        ->title('Asignación de Horarios')
        ->body($body)
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
        } 

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
        }

        return $scheduleCreate;
    }

    /**
     * Realiza validación si lo registro ya existen y devuelve una notificación con una variable boolean
     * @param Array $data
     * @return boolean
     */
    public function validateExistShedule($data){

        $body = "";
       
        foreach ($data['dates'] as $dateEntry) {
            $dates = $dateEntry['date']; // Extraer el valor de Fecha

            // Buscar todos los registros con el mismo cetap y date
            $existingCetap = Schedule::where('cetap', $data['cetap'])
                ->where('date', $dates)
                ->where('working_day', $data['working_day'])
                ->where('semester', $data['semester'])
                ->first();

            if($existingCetap){
                if(empty($body)){
                    $body .= "El cetap " . $data['cetap'] . " tiene una asignatura " . $data['subject'] .
                    " con modalidad " . $data['mode'] . " los dias: ";
                }
                
                $body .= "<br> - " . $existingCetap->date . " en la jornada " . 
                $existingCetap->working_day . " en el semestre : " . $existingCetap->semester . "";
               
            } else {

                // Buscar todos los registros con el mismo teacher_id y date
                $existingSchedules = Schedule::where('teacher_id', $data['teacher_id'])
                ->where('date', $dates)
                ->first(); 

                if ($existingSchedules){
                    if(empty($body)){
                        $body .= "El cetap " . $data['cetap'] . " tiene una asignatura " . $data['subject'] .
                            " con modalidad " . $data['mode'] . " los dias: ";
                    }
                   
                    $body .= "<br> - " . $existingSchedules->date . " en la jornada " . 
                    $existingSchedules->working_day . " en el semestre : " . $existingSchedules->semester . "";
                }
            }            
        }
     
        if($body !== ""){
            Notification::make()
            ->title('Conflicto de horario')
            ->body($body)
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

            return false;
        } else {
            return true;
        }
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
                'resolution' => '123',
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
