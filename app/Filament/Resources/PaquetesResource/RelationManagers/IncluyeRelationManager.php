<?php

namespace App\Filament\Resources\PaquetesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class IncluyeRelationManager extends RelationManager
{
    protected static string $relationship = 'incluye';

    protected static ?string $title = 'Incluye / No incluye';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('tipo')
                ->options([
                    'incluido' => 'Incluido',
                    'no_incluido' => 'No incluido',
                ])
                ->required()
                ->native(false),
            Forms\Components\Select::make('estado')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ])
                ->default('activo'),
            Forms\Components\TextInput::make('detalle')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('detalle')
            ->columns([
                Tables\Columns\TextColumn::make('detalle')->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'incluido' ? 'success' : 'danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')->options([
                    'incluido' => 'Incluido',
                    'no_incluido' => 'No incluido',
                ]),
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
