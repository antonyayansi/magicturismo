<?php

namespace App\Filament\Resources\PaquetesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItinerariosRelationManager extends RelationManager
{
    protected static string $relationship = 'itinerarios';

    protected static ?string $title = 'Itinerario';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('titulo')->required()->maxLength(255),
            Forms\Components\TextInput::make('orden')->numeric()->default(1)->minValue(1),
            Forms\Components\RichEditor::make('desc')
                ->label('Descripción')
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titulo')
            ->reorderable('orden')
            ->defaultSort('orden')
            ->columns([
                Tables\Columns\TextColumn::make('orden')->sortable(),
                Tables\Columns\TextColumn::make('titulo')->searchable(),
                Tables\Columns\TextColumn::make('desc')->html()->limit(60),
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
