<?php

namespace App\Filament\Concerns;

trait RestrictsToAdmin
{
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }
}
