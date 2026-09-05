<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $table = 'paginas';

    protected $fillable = [
        'slug',
        'titulo',
        'extracto',
        'contenido',
        'imagen',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'estado',
    ];

    public function scopePublicadas($query)
    {
        return $query->where('estado', 'activo');
    }

    protected static function booted(): void
    {
        static::saved(fn () => \App\Services\SiteSettings::forget());
        static::deleted(fn () => \App\Services\SiteSettings::forget());
    }

    public function publicUrl(): string
    {
        if ($this->slug === 'contacto') {
            return route('contacto');
        }

        if ($this->slug === 'responsabilidad') {
            return route('responsabilidad');
        }

        return route('pagina', $this->slug);
    }
}
