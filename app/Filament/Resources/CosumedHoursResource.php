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
                Forms\Components\TextInput::make('schedules_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('consumed_hours')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cut')
                    ->label('Corte')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->label('Año')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('categorie')
                    ->required()
                    ->label('Categoría')
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_hour')
                    ->label('Valor Hora')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('resolution')
                    ->label('Resolución')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_pensioner')
                    ->label('Valor Pensionado')
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_total')
                    ->label('Total')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedule.teacher.full_name')
                    ->label('Docente')  // Etiqueta personalizada para la columna
                    ->sortable(),       // Hace que la columna sea ordenable
                Tables\Columns\TextColumn::make('schedule.date')
                    ->label('Fecha')     // Etiqueta personalizada para la columna
                    ->date(('d/m'))             // Formato de fecha (puedes agregar un formato personalizado si deseas)
                    ->sortable(),        // Hace que la columna sea ordenable
                Tables\Columns\TextColumn::make('consumed_hours')
                    ->label('Horas Consumidas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cut')
                    ->label('Corte')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Año')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->label('Categoría')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_hour')
                    ->label('Valor Hora')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resolution')
                    ->label('Resolución')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_pensioner')
                    ->label('Valor Pensionado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_total')
                    ->label('Total')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
