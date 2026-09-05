<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class traducciones extends Model
{
    use HasFactory;
    protected $table = 'traducciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'idioma_id',
        'paquete_id',
        'created_at',
        'updated_at'
    ];

    // Relación con el modelo 'Idioma' (una traducción pertenece a un idioma)
    public function idioma()
    {
        return $this->belongsTo(idioma::class, 'idioma_id');
    }

    // Relación con el modelo 'Paquete' (una traducción pertenece a un paquete)
    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
