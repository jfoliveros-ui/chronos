<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use App\Models\Parameter;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationLabel = 'Asignar Horario';
    protected static ?string $navigationGroup = 'Asignaciones';
    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'icon-asig_hor';

    /*public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }*/

    public static function getModelLabel(): string
    {
        return __('filament.resources.schedule');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.schedules');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cetap')
                    ->label('Centro de Tutoría')
                    ->options(
                        Parameter::where('parameter', 'CETAP')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
                    ->required(),
                Forms\Components\Select::make('subject')
                    ->label('Materia')
                    ->options(
                        Parameter::where('parameter', 'MATERIA')
                            ->pluck('value', 'value') // Muestra y guarda el valor de la columna "value"
                    )
                    ->required()
                    ->reactive() // Hacemos el campo reactivo para que el cambio actualice "teacher_id"
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Cuando se actualiza el valor de 'subject', busca el 'teacher_id' asociado en la tabla "subjects"
                        $teacherId = Subject::where('subject', $state)->first()->teacher_id ?? null;
                        $set('teacher_id', $teacherId); // Asignamos el 'teacher_id' correspondiente
                    }),
                Forms\Components\Select::make('semester')
                    ->label('Semestre')
                    ->options(
                        Parameter::where('parameter', 'SEMESTRE')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Docente')
                    ->options(function ($get) {
                        // Buscamos la materia seleccionada en el modelo Subject
                        $subject = Subject::where('subject', $get('subject'))->first();
                        return $subject ? [$subject->teacher_id => $subject->teacher->full_name] : [];
                    })
                    ->required(),
                Forms\Components\Select::make('working_day')
                    ->label('Jornada')
                    ->options(
                        Parameter::where('parameter', 'JORNADA')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
                    ->required(),
                Forms\Components\Select::make('mode')
                    ->label('Modalidad')
                    ->options(
                        Parameter::where('parameter', 'MODALIDAD')
                            ->pluck('value', 'value') // Muestra y guarda el valor de la columna "value"
                    )
                    ->required(),
                Forms\Components\Repeater::make('dates')
                    ->label('Fechas')
                    ->schema([
                        DatePicker::make('date')
                            ->label('Fecha')
                            ->required(),
                    ])
                    ->minItems(1) // El mínimo de fechas que el usuario puede ingresar
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher.full_name')
                    ->label('Docente')
                    ->searchable(isIndividual: true)
                    ->sortable(),
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
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}