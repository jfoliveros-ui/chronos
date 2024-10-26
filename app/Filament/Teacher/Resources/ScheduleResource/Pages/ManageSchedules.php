<?php

namespace App\Filament\Teacher\Resources\ScheduleResource\Pages;

use App\Filament\Teacher\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSchedules extends ManageRecords
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
