<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CosumedHoursResource\Pages;
use App\Models\CosumedHours;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Indicator;
use Carbon\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\IconColumn;



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
                    ->date(('d/m/y'))             // Formato de fecha (puedes agregar un formato personalizado si deseas)
                    ->sortable(),        // Hace que la columna sea ordenable
                Tables\Columns\TextColumn::make('consumed_hours')
                    ->label('Horas Consumidas')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cut')
                    ->label('Corte')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Año')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->label('Categoría')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_hour')
                    ->numeric(
                        decimalPlaces: 0,
                    )
                    ->prefix('$')
                    ->label('Valor Hora')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resolution')
                    ->label('Resolución')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_pensioner')
                    ->label('Valor Pensionado')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('value_total')
                    ->prefix('$')
                    ->label('Total')
                    ->summarize(
                        Sum::make()->label('Total Víaticos')->numeric(
                            decimalPlaces: 0,
                        )
                    )->numeric(
                        decimalPlaces: 0,
                    )->prefix('$')
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
            ->striped()
            ->filters([
                DateRangeFilter::make('schedule_date')
                    ->label('Rango de Fechas')
                    ->modifyQueryUsing(function (Builder $query, ?Carbon $startDate, ?Carbon $endDate) {
                        return $query->when(
                            $startDate && $endDate,
                            fn(Builder $query) =>
                            $query->whereHas(
                                'schedule',
                                fn($q) =>
                                $q->whereBetween('date', [$startDate, $endDate])
                            )
                        );
                    }),
            ]/*, layout: FiltersLayout::Modal*/)

            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filtro'),
            )
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
