<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItinerarioPaqueteResource\Pages;
use App\Filament\Resources\ItinerarioPaqueteResource\RelationManagers;
use App\Models\ItinerarioPaquete;
use App\Models\Paquetes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItinerarioPaqueteResource extends Resource
{
    protected static ?string $model = ItinerarioPaquete::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    public static function getModelLabel(): string
    {
        return 'Itinerario';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Itinerario';
    }

    public static function getNavigationLabel(): string
    {
        return 'Itinerario';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paquete_id')
                    ->required()
                    ->label('Paquete')
                    ->options(Paquetes::all()->pluck('titulo', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('titulo')
                    ->required(),
                Forms\Components\RichEditor::make('desc')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paquete.titulo')
                    ->label('Paquete')
                    ->searchable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('desc')
                    ->label('Descripción')
                    ->limit(50),
                Tables\Columns\TextColumn::make('orden')
                    ->label('Orden'),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->dateTime(),
            ])->filters([
                //
            ])->headerActions([
                //
            ])->actions([
                //
            ])->bulkActions([
                //
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
            'index' => Pages\ListItinerarioPaquetes::route('/'),
            'create' => Pages\CreateItinerarioPaquete::route('/create'),
            'edit' => Pages\EditItinerarioPaquete::route('/{record}/edit'),
        ];
    }
}
