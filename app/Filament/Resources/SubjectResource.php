<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use App\Models\Parameter;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationGroup = 'Asignaciones';

    protected static ?string $navigationIcon = 'icon-asig_mat';

    protected static ?int $navigationSort = 6;


    /*public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }*/

    public static function getModelLabel(): string
    {
        return __('filament.resources.subject');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.subjects');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('teacher_id')
                    ->label('Docente')
                    ->options(
                        Teacher::pluck('full_name', 'id') // Muestra el full_name y guarda el id
                    )
                    ->required(),
                Forms\Components\Select::make('subject')
                    ->label('Materia')
                    ->options(
                        Parameter::where('parameter', 'MATERIA')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
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
                Tables\Columns\TextColumn::make('subject')
                    ->label('Materia')
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

    // Método para cargar la consulta
    protected function getTableQuery()
    {
        return Subject::with('Teacher'); // Carga la relación 'teacher'
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubjects::route('/'),
        ];
    }
}
