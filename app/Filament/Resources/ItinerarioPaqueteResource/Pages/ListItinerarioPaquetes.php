<?php

namespace App\Filament\Resources\ItinerarioPaqueteResource\Pages;

use App\Filament\Resources\ItinerarioPaqueteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItinerarioPaquetes extends ListRecords
{
    protected static string $resource = ItinerarioPaqueteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
