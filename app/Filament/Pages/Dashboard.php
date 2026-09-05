<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Inicio';

    protected static ?string $title = 'Panel de la agencia';

    public function getColumns(): int | string | array
    {
        return 12;
    }

    public function getSubheading(): ?string
    {
        return 'Reservas por atender, viajes próximos y estado del catálogo.';
    }
}
