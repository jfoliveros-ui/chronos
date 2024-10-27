<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Usuarios';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'icon-user';
    /*public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }*/

    public static function getModelLabel(): string
    {
        return __('filament.resources.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),
                    forms\Components\Select::make('roles')
                    ->label('Rol')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Encripta aquí
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rol'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
