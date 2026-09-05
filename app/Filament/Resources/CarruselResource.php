<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarruselResource\Pages;
use App\Models\Carrusel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarruselResource extends Resource
{
    protected static ?string $model = Carrusel::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Contenido CMS';

    protected static ?string $navigationLabel = 'Carrusel';

    protected static ?string $modelLabel = 'Slide';

    protected static ?string $pluralModelLabel = 'Carrusel';

    protected static ?int $navigationSort = 4;

    protected static bool $isGloballySearchable = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')->maxLength(255),
                Forms\Components\TextInput::make('subtitulo')->maxLength(255),
                Forms\Components\Textarea::make('texto')->rows(3)->columnSpanFull(),
                Forms\Components\TextInput::make('boton')
                    ->label('Enlace del botón')
                    ->url()
                    ->maxLength(255)
                    ->helperText('URL completa del botón "Explorar Más".'),
                Forms\Components\Select::make('tipo')
                    ->label('Tipo de contenido')
                    ->options([
                        'imagen' => 'Imagen',
                        'video' => 'Video',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\FileUpload::make('url')
                    ->label('Archivo')
                    ->directory('carrusel')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'video/mp4',
                        'video/webm',
                        'video/quicktime',
                    ])
                    ->maxSize(102400)
                    ->required()
                    ->helperText('Imagen o video. Máximo 100 MB. Se guarda en storage/app/public/carrusel.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('subtitulo')->toggleable(),
                Tables\Columns\TextColumn::make('tipo')->badge()->sortable(),
                Tables\Columns\TextColumn::make('boton')->label('Botón')->limit(30)->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')->options([
                    'imagen' => 'Imagen',
                    'video' => 'Video',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isAdmin()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarrusels::route('/'),
            'create' => Pages\CreateCarrusel::route('/create'),
            'edit' => Pages\EditCarrusel::route('/{record}/edit'),
        ];
    }
}
