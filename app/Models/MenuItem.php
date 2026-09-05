<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'ubicacion',
        'label',
        'url',
        'ruta',
        'parent_id',
        'orden',
        'visible',
        'target',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.menus'));
        static::deleted(fn () => Cache::forget('site.menus'));
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('visible', true)->orderBy('orden');
    }

    public function href(): string
    {
        if ($this->ruta && \Illuminate\Support\Facades\Route::has($this->ruta)) {
            return route($this->ruta);
        }

        return $this->url ?: '#';
    }

    public static function forLocation(string $ubicacion)
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable((new static)->getTable())) {
            return collect();
        }

        $menus = Cache::remember('site.menus', 3600, function () {
            return static::query()
                ->where('visible', true)
                ->whereNull('parent_id')
                ->with('children')
                ->orderBy('orden')
                ->get()
                ->groupBy('ubicacion');
        });

        return $menus->get($ubicacion, collect());
    }
}
