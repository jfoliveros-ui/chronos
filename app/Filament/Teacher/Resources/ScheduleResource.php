<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\ScheduleResource\Pages;
use App\Filament\Teacher\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'icon-calendar';

    protected static ?string $navigationLabel = 'Consulta de Horario';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.schedules');
    }

    //función para que solo muestre los registros del usuario autenticado
    public static function getEloquentQuery(): Builder
    {
        // Obtener el nombre completo del usuario autenticado
        $nombreCompleto = Auth::user()->name;

        return parent::getEloquentQuery()
            ->whereHas('teacher', function (Builder $query) use ($nombreCompleto) {
                // Filtra los registros de Teacher donde 'full_name' coincida con el nombre completo del usuario autenticado
                $query->where('full_name', $nombreCompleto);
            })
            ->with('teacher.user'); // Cargar la relación teacher.user para optimización
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*Tables\Columns\TextColumn::make('teacher.full_name')
                    ->label('Docente')
                    ->sortable(),*/

                Tables\Columns\TextColumn::make('cetap')
                    ->label('Centro de Tutoría')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->label('Semestre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Materia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date('d/m')
                    ->sortable(),
                Tables\Columns\TextColumn::make('working_day')
                    ->label('Jornada')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode')
                    ->label('Modalidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission')
                    ->label('Comisión')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Asignada' => 'warning',
                        'Cumplida' => 'success',
                        'No Cumplida' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}
