<?php

namespace App\Filament\Resources\CosumedHoursResource\Pages;

use App\Filament\Resources\CosumedHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCosumedHours extends ManageRecords
{
    protected static string $resource = CosumedHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
