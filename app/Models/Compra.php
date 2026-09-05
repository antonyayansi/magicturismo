<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';

    protected $primaryKey = 'id';

    protected $fillable = [
        'paquete_id',
        'usuario_id',
        'cantidad_personas',
        'fecha_compra',
        'estado',
        'created_at',
        'updated_at'
    ];

    // Relación con la tabla 'paquetes' (una reserva pertenece a un paquete)
    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    // Relación con la tabla 'users' (una reserva pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    protected $dates = ['created_at', 'updated_at', 'fecha_reserva'];
}
