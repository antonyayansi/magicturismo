<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class redesociales extends Model
{
    use HasFactory;
    protected $table = 'redesociales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'icono',
        'url',
        'created_at',
        'updated_at'
    ];


    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
