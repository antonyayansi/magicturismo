<?php

namespace App\Filament\Resources\IncluyePaqueteResource\Pages;

use App\Filament\Resources\IncluyePaqueteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncluyePaquete extends EditRecord
{
    protected static string $resource = IncluyePaqueteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
