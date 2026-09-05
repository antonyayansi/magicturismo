<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservaEstadoResource\Pages;
use App\Models\ReservaEstado;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ReservaEstadoResource extends Resource
{
    protected static ?string $model = ReservaEstado::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Operaciones';

    protected static ?string $navigationLabel = 'Estados de reserva';

    protected static ?string $modelLabel = 'Estado';

    protected static ?string $pluralModelLabel = 'Estados de reserva';

    protected static ?int $navigationSort = 3;

    protected static bool $isGloballySearchable = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(80)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, ?ReservaEstado $record) {
                    if (! $record) {
                        $set('clave', Str::slug((string) $state, '_'));
                    }
                }),
            Forms\Components\TextInput::make('clave')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(80)
                ->disabled(fn (?ReservaEstado $record) => $record?->protegido)
                ->dehydrated()
                ->helperText('Identificador interno. No se puede cambiar en los estados base.'),
            Forms\Components\Select::make('color')
                ->options([
                    'warning' => 'Amarillo',
                    'success' => 'Verde',
                    'info' => 'Azul',
                    'primary' => 'Azul marca',
                    'danger' => 'Rojo',
                    'gray' => 'Gris',
                ])
                ->default('gray')
                ->required(),
            Forms\Components\TextInput::make('orden')
                ->numeric()
                ->default(10),
            Forms\Components\Toggle::make('activo')
                ->default(true)
                ->label('Visible en el tablero'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('orden')
            ->reorderable('orden')
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('clave')->copyable(),
                Tables\Columns\TextColumn::make('color')
                    ->badge()
                    ->color(fn (string $state) => $state),
                Tables\Columns\IconColumn::make('activo')->boolean(),
                Tables\Columns\IconColumn::make('protegido')->boolean()->label('Base'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (ReservaEstado $record) => ! $record->protegido)
                    ->before(function (ReservaEstado $record) {
                        $record->reservas()->update(['estado' => 'pendiente']);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservaEstados::route('/'),
            'create' => Pages\CreateReservaEstado::route('/create'),
            'edit' => Pages\EditReservaEstado::route('/{record}/edit'),
        ];
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return ! $record->protegido && (auth()->user()?->isAdmin() ?? false);
    }
}
