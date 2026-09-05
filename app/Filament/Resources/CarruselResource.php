<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarruselResource\Pages;
use App\Filament\Resources\CarruselResource\RelationManagers;
use App\Models\Carrusel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarruselResource extends Resource
{
    protected static ?string $model = Carrusel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo'),
                Forms\Components\TextInput::make('subtitulo'),
                Forms\Components\Textarea::make('texto'),
                Forms\Components\Select::make('tipo')
                    ->label('Tipo de contenido')
                    ->options([
                        'imagen' => 'Imagen',
                        'video' => 'Video',
                    ])
                    ->required(),
                Forms\Components\Section::make('url')
                    ->schema([
                        Forms\Components\FileUpload::make('video')
                            ->label('Video')
                            ->directory('carruseles/videos')
                            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov'])
                            ->maxSize(100240), // en KB → 100 MB

                        Forms\Components\FileUpload::make('imagen')
                            ->label('Imagen')
                            ->image()
                            ->directory('carruseles/imagenes')
                            ->maxSize(10048), // en KB → 10 MB
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo'),
                Tables\Columns\TextColumn::make('subtitulo'),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('url'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
