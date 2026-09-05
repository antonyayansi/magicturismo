<?php

namespace App\Filament\Resources\PaquetesResource\Pages;

use App\Filament\Resources\PaquetesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaquetes extends EditRecord
{
    protected static string $resource = PaquetesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
