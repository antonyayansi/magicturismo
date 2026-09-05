<?php

namespace App\Filament\Resources\TestimoniosResource\Pages;

use App\Filament\Resources\TestimoniosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonios extends EditRecord
{
    protected static string $resource = TestimoniosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->visible(fn () => auth()->user()?->isAdmin()),
        ];
    }
}
