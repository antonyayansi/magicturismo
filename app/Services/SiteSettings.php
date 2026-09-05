<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\datos_empresa;
use App\Models\Paquetes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSettings
{
    public static function datos(): ?datos_empresa
    {
        return Cache::remember('site.datos', 3600, fn () => datos_empresa::query()->first());
    }

    public static function forget(): void
    {
        Cache::forget('site.datos');
        Cache::forget('site.nav.tours');
        Cache::forget('site.nav.paquetes');
        Cache::forget('site.categorias');
    }

    public static function logoUrl(): string
    {
        $datos = static::datos();

        if ($datos?->logo) {
            return Storage::url($datos->logo);
        }

        return asset('assets/img/logo_turismo-min.png');
    }

    public static function faviconUrl(): string
    {
        $datos = static::datos();

        if ($datos?->favicon) {
            return Storage::url($datos->favicon);
        }

        return asset('assets/img/favicons/icon.ico');
    }

    public static function navTours()
    {
        return Cache::remember('site.nav.tours', 1800, function () {
            return Paquetes::query()
                ->publicados()
                ->where('tipo', 'tour')
                ->orderByDesc('id')
                ->limit(5)
                ->get(['id', 'titulo', 'slug', 'tipo']);
        });
    }

    public static function navPaquetes()
    {
        return Cache::remember('site.nav.paquetes', 1800, function () {
            return Paquetes::query()
                ->publicados()
                ->where('tipo', 'paquete')
                ->orderByDesc('id')
                ->limit(5)
                ->get(['id', 'titulo', 'slug', 'tipo']);
        });
    }

    public static function categorias()
    {
        return Cache::remember('site.categorias', 1800, function () {
            return Categoria::query()
                ->withCount('paquetes')
                ->orderBy('nombre')
                ->get();
        });
    }
}
