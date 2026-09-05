<?php

namespace App\Filament\Resources\PaquetesResource\Pages;

use App\Filament\Resources\PaquetesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Str;

class CreatePaquetes extends CreateRecord
{
    protected static string $resource = PaquetesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = Str::slug($data['titulo']);
        return $data;
    }
}
