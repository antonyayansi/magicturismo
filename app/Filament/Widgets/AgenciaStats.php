<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservasResource;
use App\Services\DashboardMetrics;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgenciaStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $m = DashboardMetrics::all();
        $estimado = number_format($m['estimado_mes'], 0);

        return [
            Stat::make('Reservas pendientes', $m['pendientes'])
                ->description($m['hoy'] === 1 ? '1 nueva hoy' : $m['hoy'].' nuevas hoy')
                ->descriptionIcon('heroicon-m-clock')
                ->color($m['pendientes'] > 0 ? 'warning' : 'success')
                ->url(ReservasResource::getUrl('index')),
            Stat::make('Esta semana', $m['semana'])
                ->description($m['mes'].' en el mes')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Viajes en 14 días', $m['proximos'])
                ->description($m['proximos_personas'].' viajeros · '.$m['personas_mes'].' pers. este mes')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Confirmado del mes', '$'.$estimado)
                ->description($m['activos'].' experiencias activas · '.$m['tours'].' tours')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
