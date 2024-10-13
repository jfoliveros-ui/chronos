<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Schedule;

class Calendar extends Page
{
    protected static ?string $navigationGroup = 'Consultas';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.pages.calendar';
    protected static ?string $navigationIcon = 'icon-calendar';

    // Cambiar el título de la página
    protected static ?string $title = 'Consulta de Horarios';
    // Cambiar el breadcrumb de la página
    protected static ?string $breadcrumb = 'Calendario';

    public array $teachers; // Cambiamos de schedules a teachers para listar docentes únicos
    public $selectedSchedule = null;

    public function mount()
    {
        $this->teachers = Schedule::with('teacher')
            ->get()
            ->pluck('teacher')
            ->unique('id') // Asegura que cada docente se muestre solo una vez
            ->toArray();
        $this->selectedSchedule = null;
    }
}
