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
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('categorie')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_hour')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('resolution')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_pensioner')
                    ->maxLength(255),
                Forms\Components\TextInput::make('value_total')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedules_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('consumed_hours')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_hour')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resolution')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_pensioner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_total')
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
