<?php

namespace App\Filament\Widgets;

use App\Services\DashboardMetrics;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ReservasChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected static ?string $heading = 'Consultas de los últimos 14 días';

    protected static ?string $maxHeight = '260px';

    protected int | string | array $columnSpan = [
        'md' => 7,
        'xl' => 8,
    ];

    protected function getData(): array
    {
        $dias = DashboardMetrics::all()['por_dia'];
        $labels = [];
        foreach (array_keys($dias) as $fecha) {
            $labels[] = Carbon::parse($fecha)->translatedFormat('d M');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reservas',
                    'data' => array_values($dias),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                ],
            ],
        ];
    }
}
