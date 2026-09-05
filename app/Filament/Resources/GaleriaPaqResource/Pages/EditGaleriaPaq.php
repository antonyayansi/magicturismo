<?php

namespace App\Filament\Resources\GaleriaPaqResource\Pages;

use App\Filament\Resources\GaleriaPaqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGaleriaPaq extends EditRecord
{
    protected static string $resource = GaleriaPaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
