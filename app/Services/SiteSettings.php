<?php

namespace App\Services;

use App\Models\Carrusel;
use App\Models\Categoria;
use App\Models\datos_empresa;
use App\Models\Paquetes;
use App\Models\Testimonios;
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
        foreach ([
            'site.datos',
            'site.nav.tours',
            'site.nav.paquetes',
            'site.categorias',
            'site.destinos',
            'site.home.carrusels',
            'site.home.tours',
            'site.home.paquetes',
            'site.home.todos',
            'site.home.diferentes',
            'site.home.testimonios',
            'site.sitemap',
            'admin.dashboard',
            'admin.reservas.pendientes',
        ] as $key) {
            Cache::forget($key);
        }
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
                ->limit(8)
                ->get(['id', 'titulo', 'slug', 'tipo', 'imagen']);
        });
    }

    public static function navPaquetes()
    {
        return Cache::remember('site.nav.paquetes', 1800, function () {
            return Paquetes::query()
                ->publicados()
                ->where('tipo', 'paquete')
                ->orderByDesc('id')
                ->limit(8)
                ->get(['id', 'titulo', 'slug', 'tipo', 'imagen']);
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

    public static function destinos()
    {
        return Cache::remember('site.destinos', 1800, function () {
            $items = Paquetes::query()
                ->publicados()
                ->whereNotNull('ubicacion')
                ->where('ubicacion', '!=', '')
                ->distinct()
                ->orderBy('ubicacion')
                ->pluck('ubicacion')
                ->filter()
                ->values();

            if ($items->isNotEmpty()) {
                return $items;
            }

            return collect(['CUSCO', 'LIMA', 'AREQUIPA', 'PUNO', 'PARACAS', 'ICA', 'NAZCA', 'AMAZONÍA']);
        });
    }

    public static function homeCarrusels()
    {
        return Cache::remember('site.home.carrusels', 1800, function () {
            return Carrusel::query()->orderByDesc('id')->get();
        });
    }

    public static function homeTours()
    {
        return Cache::remember('site.home.tours', 1800, function () {
            return Paquetes::query()->publicados()->where('tipo', 'tour')->orderByDesc('id')->get();
        });
    }

    public static function homePaquetes()
    {
        return Cache::remember('site.home.paquetes', 1800, function () {
            return Paquetes::query()->publicados()->where('tipo', 'paquete')->orderByDesc('id')->get();
        });
    }

    public static function homeTodos()
    {
        return Cache::remember('site.home.todos', 1800, function () {
            return Paquetes::query()->publicados()->orderByDesc('id')->limit(12)->get();
        });
    }

    public static function homeDiferentes()
    {
        return Cache::remember('site.home.diferentes', 1800, function () {
            return Paquetes::query()
                ->publicados()
                ->where('tipo', 'diferente')
                ->with(['galeria' => fn ($q) => $q->limit(3)])
                ->orderByDesc('id')
                ->get();
        });
    }

    public static function homeTestimonios()
    {
        return Cache::remember('site.home.testimonios', 1800, function () {
            if (! \App\Support\SchemaCache::hasTable('testimonios')) {
                return collect();
            }

            return Testimonios::query()->where('estado', 'activo')->orderByDesc('id')->get();
        });
    }
}
