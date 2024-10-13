<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

use Filament\Widgets\Widget;

class CalendarWidget extends FullCalendarWidget
{
    public $selectedSchedule;

    // Este método se ejecuta cuando se monta el componente
    public function mount($selectedSchedule = null)
    {
        $this->selectedSchedule = $selectedSchedule;
    }

    // Método que se ejecuta cuando se selecciona un nuevo docente
    public function updatedSelectedSchedule($value)
    {
        $this->selectedSchedule = $value;
        $this->refresh(); // Refresca el componente
    }

    // Función para traer eventos
    public function fetchEvents(array $fetchInfo): array
    {
        // Asegúrate de verificar si el docente está seleccionado
        if ($this->selectedSchedule) {
            // Obtener el año actual
            $currentYear = Carbon::now()->year;

            // Filtrar eventos por docente y por año completo
            $events = Schedule::whereYear('date', $currentYear)
                ->where('teacher_id', $this->selectedSchedule)
                ->with('teacher')
                ->get()
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'title' => $schedule->working_day . ' - ' .  $schedule->cetap . ' - ' .  $schedule->mode,
                        'start' => $schedule->date,
                        'end' => $schedule->date,
                    ];
                });

            return $events->toArray();
        }

        return [];
    }
}
