<?php

namespace App\Filament\Resources\ReservaEstadoResource\Pages;

use App\Filament\Resources\ReservaEstadoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservaEstados extends ListRecords
{
    protected static string $resource = ReservaEstadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nuevo estado'),
        ];
    }
}
