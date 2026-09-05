<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservasResource;
use App\Models\ReservaEstado;
use App\Models\Reservas;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProximosViajes extends BaseWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected static ?string $heading = 'Próximos viajes';

    protected int | string | array $columnSpan = [
        'md' => 6,
        'xl' => 6,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservas::query()
                    ->with('paquete:id,titulo,tipo')
                    ->whereDate('fecha_reserva', '>=', today())
                    ->whereIn('estado', ['pendiente', 'pagado'])
                    ->orderBy('fecha_reserva')
                    ->limit(6)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('fecha_reserva')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente')
                    ->searchable()
                    ->limit(22),
                Tables\Columns\TextColumn::make('paquete.titulo')
                    ->label('Tour / paquete')
                    ->placeholder('—')
                    ->limit(28),
                Tables\Columns\TextColumn::make('cantidad_personas')
                    ->label('Pers.')
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => ReservaEstado::etiqueta($state))
                    ->color(fn (?string $state) => ReservaEstado::colorFilament($state)),
            ])
            ->recordUrl(fn (Reservas $record) => ReservasResource::getUrl('edit', ['record' => $record]));
    }
}
