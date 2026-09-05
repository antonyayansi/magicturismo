<?php

namespace App\Filament\Resources\ReservaEstadoResource\Pages;

use App\Filament\Resources\ReservaEstadoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReservaEstado extends EditRecord
{
    protected static string $resource = ReservaEstadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => ! $this->record->protegido && auth()->user()?->isAdmin()),
        ];
    }
}
