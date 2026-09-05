<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PaquetesResource;
use App\Models\Paquetes;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopExperiencias extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected static ?string $heading = 'Experiencias más pedidas';

    protected int | string | array $columnSpan = [
        'md' => 5,
        'xl' => 4,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Paquetes::query()
                    ->withCount('reservas')
                    ->withSum('reservas', 'cantidad_personas')
                    ->orderByDesc('reservas_count')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Experiencia')
                    ->limit(32)
                    ->url(fn (Paquetes $record) => PaquetesResource::getUrl('edit', ['record' => $record])),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'tour' => 'Tour',
                        'paquete' => 'Paquete',
                        'caminata', 'treks' => 'Caminata',
                        'diferente' => 'Otro',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('reservas_count')
                    ->label('Reservas')
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservas_sum_cantidad_personas')
                    ->label('Pers.')
                    ->alignEnd()
                    ->placeholder('0'),
            ]);
    }
}
