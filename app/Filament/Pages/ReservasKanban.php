<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ReservaEstadoResource;
use App\Filament\Resources\ReservasResource;
use App\Models\ReservaEstado;
use App\Models\Reservas;
use App\Services\DashboardMetrics;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ReservasKanban extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static string $view = 'filament.pages.reservas-kanban';

    protected static ?string $navigationGroup = 'Operaciones';

    protected static ?string $navigationLabel = 'Tablero';

    protected static ?string $title = 'Tablero de reservas';

    protected static ?int $navigationSort = 0;

    public function getSubheading(): ?string
    {
        return 'Arrastra una tarjeta para cambiar de estado.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('lista')
                ->label('Ver lista')
                ->url(ReservasResource::getUrl('index'))
                ->color('gray'),
            Actions\Action::make('estados')
                ->label('Estados')
                ->url(ReservaEstadoResource::getUrl('index'))
                ->color('gray'),
            Actions\Action::make('crear')
                ->label('Nueva reserva')
                ->url(ReservasResource::getUrl('create')),
        ];
    }

    public function getViewData(): array
    {
        $estados = ReservaEstado::query()->activos()->get();
        $reservas = Reservas::query()
            ->with('paquete:id,titulo')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('estado');

        return [
            'estados' => $estados,
            'reservasPorEstado' => $reservas,
        ];
    }

    public function mover(int $reservaId, string $estado): void
    {
        $valido = ReservaEstado::catalogo()->has($estado);
        if (! $valido) {
            Notification::make()->title('Estado no válido')->danger()->send();

            return;
        }

        $reserva = Reservas::query()->find($reservaId);
        if (! $reserva) {
            return;
        }

        $reserva->estado = $estado;
        $reserva->save();
        ReservaEstado::forget();
        DashboardMetrics::forget();

        Notification::make()
            ->title('Reserva actualizada')
            ->body($reserva->cliente.' → '.ReservaEstado::etiqueta($estado))
            ->success()
            ->send();
    }
}
