<?php

namespace App\Models;

use App\Services\SiteSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonios extends Model
{
    use HasFactory;
    protected $table = 'testimonios';
    protected $fillable = [
        'nombres',
        'cargo',
        'texto',
        'estado'
    ];

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::forget());
        static::deleted(fn () => SiteSettings::forget());
    }
}
