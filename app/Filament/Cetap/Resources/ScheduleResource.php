<?php

namespace App\Filament\Cetap\Resources;

use App\Filament\Cetap\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Auth;


class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationLabel = 'Consulta de Horario';
    protected static ?string $navigationIcon = 'icon-asig_hor';

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.schedules');
    }

    public static function getEloquentQuery(): Builder
    {
        // Obtener el nombre del usuario autenticado
        $nombreUsuario = Auth::user()->name;

        return parent::getEloquentQuery()
            ->where('cetap', $nombreUsuario); // Filtra los registros de Schedule donde cetap coincide con el nombre del usuario
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cetap')
                    ->label('Centro de Tutoría')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->label('Materia')
                    ->disabled(),
                Forms\Components\TextInput::make('semester')
                    ->label('Semestre')
                    ->disabled(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Docente')

                    ->searchable()
                    ->disabled(),
                Forms\Components\TextInput::make('working_day')
                    ->label('Jornada')
                    ->disabled(),
                Forms\Components\TextInput::make('mode')
                    ->label('Modalidad')
                    ->disabled(),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->disabled(),
                Forms\Components\Select::make('commission')
                ->label('Comisión')
                ->options([
                    'Cumplida' => 'Cumplida',
                    'No Cumplida' => 'No Cumplida',
                ])
                //->disabled(fn ($get) => in_array($get('commission'), ['Cumplida', 'No Cumplida']))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher.full_name')
                    ->label('Docente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.phone')
                    ->label('Celular')
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
                Tables\Columns\TextColumn::make('mode')
                    ->label('Modalidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('working_day')
                    ->label('Jornada')
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
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}
