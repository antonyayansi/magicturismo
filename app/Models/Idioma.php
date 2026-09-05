<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;
    protected $table = 'idiomas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'idioma',
        'prefijo',
        'created_at',
        'updated_at'
    ];


    // Relación con la tabla 'traducciones' (un idioma puede tener muchas traducciones)
    public function traducciones()
    {
        return $this->hasMany(traducciones::class, 'idioma_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
