<?php

namespace App\Filament\Cetap\Resources;

use App\Filament\Cetap\Resources\ScheduleResource\Pages;
use App\Filament\Cetap\Resources\ScheduleResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->schema([
                Forms\Components\TextInput::make('teacher_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cetap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('working_day')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cetap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('working_day')
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

            ])
            ->bulkActions([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}
