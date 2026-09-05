<?php

namespace App\Filament\Resources\PaquetesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GaleriaRelationManager extends RelationManager
{
    protected static string $relationship = 'galeria';

    protected static ?string $title = 'Galería';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('img')
                ->label('Imagen')
                ->image()
                ->directory('paquetes/imagenes')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->maxSize(4096)
                ->required()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('desc')
                ->label('Descripción / alt')
                ->maxLength(255)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('desc')
            ->columns([
                Tables\Columns\ImageColumn::make('img')->circular(),
                Tables\Columns\TextColumn::make('desc')->label('Descripción')->searchable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
