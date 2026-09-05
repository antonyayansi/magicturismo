<?php

namespace App\Filament\Resources\GaleriaPaqResource\Pages;

use App\Filament\Resources\GaleriaPaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGaleriaPaqs extends ListRecords
{
    protected static string $resource = GaleriaPaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
