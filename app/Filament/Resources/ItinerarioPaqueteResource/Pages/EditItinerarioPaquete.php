<?php

namespace App\Filament\Resources\ItinerarioPaqueteResource\Pages;

use App\Filament\Resources\ItinerarioPaqueteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItinerarioPaquete extends EditRecord
{
    protected static string $resource = ItinerarioPaqueteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
