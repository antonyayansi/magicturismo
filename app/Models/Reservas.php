<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;
    protected $table = 'reservas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'paquete_id',
        'cliente',
        'email',
        'comentario',
        'cantidad_personas',
        'fecha_reserva',
        'estado',
        'created_at',
        'updated_at'
    ];

    // Relación con la tabla 'paquetes' (una reserva pertenece a un paquete)
    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    public function estadoRegistro()
    {
        return $this->belongsTo(ReservaEstado::class, 'estado', 'clave');
    }

    // Relación con la tabla 'users' (una reserva pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    protected $dates = ['created_at', 'updated_at', 'fecha_reserva'];

    protected static function booted(): void
    {
        static::saved(fn () => \App\Services\DashboardMetrics::forget());
        static::deleted(fn () => \App\Services\DashboardMetrics::forget());
    }
}
