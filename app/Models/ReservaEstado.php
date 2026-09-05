<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReservaEstado extends Model
{
    protected $table = 'reserva_estados';

    protected $fillable = [
        'clave',
        'nombre',
        'color',
        'orden',
        'activo',
        'protegido',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'protegido' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::forget());
        static::deleted(fn () => static::forget());
    }

    public static function forget(): void
    {
        Cache::forget('admin.reserva_estados');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden')->orderBy('id');
    }

    public static function catalogo()
    {
        return Cache::remember('admin.reserva_estados', 300, function () {
            if (! \App\Support\SchemaCache::hasTable((new static)->getTable())) {
                return collect();
            }

            return static::query()->activos()->get()->keyBy('clave');
        });
    }

    public static function opciones(): array
    {
        return static::catalogo()->mapWithKeys(fn (self $estado) => [$estado->clave => $estado->nombre])->all();
    }

    public static function etiqueta(?string $clave): string
    {
        if (! $clave) {
            return '—';
        }

        return static::catalogo()[$clave]->nombre ?? $clave;
    }

    public static function colorFilament(?string $clave): string
    {
        return static::catalogo()[$clave]->color ?? 'gray';
    }

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'estado', 'clave');
    }
}
