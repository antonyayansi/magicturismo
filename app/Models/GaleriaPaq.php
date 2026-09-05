<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriaPaq extends Model
{
    use HasFactory;

    protected $table = 'galeria_paq';

    // Define la clave primaria (opcional si es 'id')
    protected $primaryKey = 'id';

    // Define los campos que son asignables masivamente
    protected $fillable = [
        'paquete_id',
        'img',
        'desc',
        'created_at',
        'updated_at'
    ];

    
    // Relación con el paquete (relación inversa de uno a muchos)
    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
