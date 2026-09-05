<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itinerario_paquete extends Model
{
    use HasFactory;
    protected $table = 'itinerario_paquete';

    protected $primaryKey = 'id';
    protected $fillable = [
        'paquete_id',
        'titulo',
        'desc',
        'orden',
        'fecha',
        'created_at',
        'updated_at'
    ];


    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at', 'fecha'];
}
