<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncluyePaqueteResource\Pages;
use App\Filament\Resources\IncluyePaqueteResource\RelationManagers;
use App\Models\IncluyePaquete;
use App\Models\Paquetes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncluyePaqueteResource extends Resource
{
    protected static ?string $model = IncluyePaquete::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paquete_id')
                    ->required()
                    ->label('Paquete')
                    ->options(Paquetes::all()->pluck('titulo', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('tipo')
                    ->options([
                        'incluido' => 'Incluido',
                        'no_incluido' => 'No incluido',
                    ])
                    ->default('incluido')
                    ->required(),
                Forms\Components\TextInput::make('detalle')
                    ->required()
                    ->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paquete.titulo')
                    ->label('Paquete')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('detalle')
                    ->label('Detalle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'no_incluido' => 'danger',
                        'incluido' => 'success',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListIncluyePaquetes::route('/'),
            'create' => Pages\CreateIncluyePaquete::route('/create'),
            'edit' => Pages\EditIncluyePaquete::route('/{record}/edit'),
        ];
    }
}
