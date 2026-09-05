<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $table = 'paginas';

    protected $fillable = [
        'slug',
        'titulo',
        'extracto',
        'contenido',
        'imagen',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'estado',
    ];

    public function scopePublicadas($query)
    {
        return $query->where('estado', 'activo');
    }
}
