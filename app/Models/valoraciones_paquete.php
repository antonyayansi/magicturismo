<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class valoraciones_paquete extends Model
{
    use HasFactory;
    protected $table = 'valoraciones_paquete';

    protected $primaryKey = 'id';

    protected $fillable = [
        'paquete_id',
        'usuario_id',
        'valoracion',
        'comentario',
        'estado',
        'created_at',
        'updated_at'
    ];

    // Relación con la tabla 'paquetes' (una valoración pertenece a un paquete)
    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    // Relación con la tabla 'users' (una valoración pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
