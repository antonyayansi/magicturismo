<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Contenido extends Model
{
    protected $table = 'contenidos';

    protected $fillable = [
        'clave',
        'grupo',
        'titulo',
        'texto',
        'imagen',
        'extra',
        'orden',
        'estado',
    ];

    protected $casts = [
        'extra' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.contenidos'));
        static::deleted(fn () => Cache::forget('site.contenidos'));
    }

    public static function catalogo(): array
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable((new static)->getTable())) {
            return [];
        }

        return Cache::remember('site.contenidos', 3600, function () {
            return static::query()
                ->where('estado', 'activo')
                ->orderBy('orden')
                ->get()
                ->keyBy('clave')
                ->all();
        });
    }

    public static function texto(string $clave, ?string $default = null): string
    {
        $item = static::catalogo()[$clave] ?? null;

        return $item?->texto ?: ($default ?? '');
    }

    public static function titulo(string $clave, ?string $default = null): string
    {
        $item = static::catalogo()[$clave] ?? null;

        return $item?->titulo ?: ($default ?? '');
    }

    public static function imagen(string $clave, ?string $default = null): ?string
    {
        $item = static::catalogo()[$clave] ?? null;

        return $item?->imagen ?: $default;
    }

    public static function imagenUrl(string $clave, ?string $default = null): string
    {
        $path = static::imagen($clave);

        if ($path) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        return $default ?: '';
    }
}
