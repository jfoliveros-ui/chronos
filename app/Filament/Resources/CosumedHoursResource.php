<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CosumedHoursResource\Pages;
use App\Filament\Resources\CosumedHoursResource\RelationManagers;
use App\Models\CosumedHours;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CosumedHoursResource extends Resource
{
    protected static ?string $model = CosumedHours::class;

    protected static ?string $navigationIcon = 'icon-viaticos';
    protected static ?string $navigationGroup = 'Viáticos';
    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('filament.resources.Cosumed Hours');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCosumedHours::route('/'),
        ];
    }
}
