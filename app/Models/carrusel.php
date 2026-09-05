<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carrusel extends Model
{
    use HasFactory;
    protected $table = 'carrusel';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
        'url',
        'titulo',
        'subtitulo',
        'texto',
        'boton',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
