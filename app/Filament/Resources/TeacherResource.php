<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use Illuminate\Support\Facades\Storage;
use App\Models\Parameter;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\FileUpload;


class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationGroup = 'Usuarios';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'icon-crear_doc';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function getModelLabel(): string
    {
        return __('filament.resources.teacher');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.teachers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type_document')
                    ->label('Tipo de Documento')
                    ->options(
                        Parameter::where('parameter', 'TIPO DOCUMENTO')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
                    ->required(),
                Forms\Components\TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('full_name')
                    ->label('Nombres y Apellidos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label('Dirección')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('origin')
                    ->label('Origen')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('categorie')
                    ->label('Categoría')
                    ->options(
                        Parameter::where('parameter', 'CATEGORIA')
                            ->pluck('value', 'value') // Muestra el valor de value y guarda el valor de value
                    )
                    ->required(),
                Forms\Components\Select::make('pensioner')
                    ->label('Pensionado')
                    ->options([
                        'si' => 'SI',
                        'no' => 'NO',
                    ])
                    ->native(false)
                    ->required(),
                    FileUpload::make('curriculum')
                    ->directory('curriculums') // Carpeta donde se almacenarán los archivos
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get) {
                        // Obtener el valor de document_number desde el formulario
                        $documentNumber = $get('document_number');

                        // Generar el nombre del archivo basado en document_number
                        $fileName = "{$documentNumber}.pdf";

                        // Verificar si ya existe un archivo con el mismo nombre en la carpeta 'curriculums'
                        $filePath = "curriculums/{$fileName}";
                        if (Storage::exists($filePath)) {
                            // Si existe, eliminarlo
                            Storage::delete($filePath);
                        }

                        // Guardar el archivo en la carpeta 'curriculums'
                        return $fileName; // Retornar el nombre del archivo para que se guarde correctamente
                    })
                    ->acceptedFileTypes(['application/pdf']) // Solo aceptar PDFs
                    ->maxSize(10240) // Limitar el tamaño a 10MB
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type_document')
                    ->label('Tipo de Documento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->label('Número de Documento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nombres y Apellidos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable(),
                Tables\Columns\TextColumn::make('origin')
                    ->label('Origen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->label('Categoría')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pensioner')
                    ->label('Pensionado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curriculum')
                    ->label('Hoja de Vida')
                    ->formatStateUsing(function ($state) {
                        // Verificar si existe el archivo
                        if ($state) {
                            // Retornar un enlace al archivo
                            return '<a href="' . Storage::url($state) . '" target="_blank">Ver Hoja de vida</a>';
                        }
                        return 'No hay Hoja de vida cargada';
                    })
                    ->html() // Permitir HTML en la columna
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
            'index' => Pages\ManageTeachers::route('/'),
        ];
    }
}
