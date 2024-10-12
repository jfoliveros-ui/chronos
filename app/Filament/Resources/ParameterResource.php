<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Facades\FilamentIcon;

class ParameterResource extends Resource
{
    protected static ?string $model = Parameter::class;
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'icon-parameter';
    public static function getModelLabel(): string
    {
        return __('filament.resources.parameter');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.parameters');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('parameter')
                    ->label('Parámetro')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('additional_value')
                    ->label('Valor Adicional')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parameter')
                    ->label('Parámetro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('additional_value')
                    ->label('Valor Adicional')
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
            'index' => Pages\ManageParameters::route('/'),
        ];
    }
}
