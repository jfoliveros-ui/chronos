<x-filament-panels::page>
    <x-filament::input.wrapper>
        <x-filament::input.select wire:model.live="selectedSchedule">
            <option value="">Seleccionar Docente</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher['id'] }}">
                    {{ $teacher['full_name'] }}
                </option>
            @endforeach
        </x-filament::input.select>
    </x-filament::input.wrapper>

    {{-- Incluir el widget de calendario --}}
    @livewire(\App\Filament\Widgets\CalendarWidget::class, ['selectedSchedule' => $selectedSchedule], key($selectedSchedule))
</x-filament-panels::page>
