<?php

namespace App\Filament\Resources\CarruselResource\Pages;

use App\Filament\Resources\CarruselResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCarrusel extends CreateRecord
{
    protected static string $resource = CarruselResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asumimos que dependiendo del tipo se guarda en 'video' o 'imagen'
        $data['url'] = $data['tipo'] === 'video' ? $data['video'] : $data['imagen'];

        return $data;
    }
}
