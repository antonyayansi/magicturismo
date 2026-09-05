<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservasResource\Pages;
use App\Filament\Resources\ReservasResource\RelationManagers;
use App\Models\Paquetes;
use App\Models\Reservas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservasResource extends Resource
{
    protected static ?string $model = Reservas::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cliente')
                    ->required()
                    ->label('Nombre del cliente')
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->label('Correo del cliente')
                    ->maxLength(255),
                TextInput::make('cantidad_personas')
                    ->required()
                    ->label('Cantidad de personas')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100),
                Select::make('paquete_id')
                    ->required()
                    ->label('Paquete')
                    ->options(Paquetes::all()->pluck('titulo', 'id'))
                    ->searchable(),
                Textarea::make('comentario')
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('comentario'),
                Tables\Columns\TextColumn::make('cantidad_personas'),
                Tables\Columns\TextColumn::make('fecha_reserva'),
                Tables\Columns\TextColumn::make('estado')
                ->getStateUsing(fn ($record) => match($record->estado) {
                    'pendiente' => 'Pendiente',
                    'pagado' => 'Pagado',
                    'atendido' => 'Atendido',
                    default => $record->estado,
                })
                ->color(fn ($state) => match($state) {
                    'Pendiente' => 'warning',
                    'Pagado' => 'success',
                    'Atendido' => 'primary',
                    default => null,
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
            'index' => Pages\ListReservas::route('/'),
            'create' => Pages\CreateReservas::route('/create'),
            'edit' => Pages\EditReservas::route('/{record}/edit'),
        ];
    }
}
