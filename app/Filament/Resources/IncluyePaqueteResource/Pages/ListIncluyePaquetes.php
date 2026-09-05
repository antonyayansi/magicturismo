<?php

namespace App\Filament\Resources\IncluyePaqueteResource\Pages;

use App\Filament\Resources\IncluyePaqueteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncluyePaquetes extends ListRecords
{
    protected static string $resource = IncluyePaqueteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
