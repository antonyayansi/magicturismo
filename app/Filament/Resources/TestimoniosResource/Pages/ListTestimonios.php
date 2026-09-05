<?php

namespace App\Filament\Resources\TestimoniosResource\Pages;

use App\Filament\Resources\TestimoniosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestimonios extends ListRecords
{
    protected static string $resource = TestimoniosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
