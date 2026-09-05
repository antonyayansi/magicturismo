<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    // Define la clave primaria (opcional si es 'id')
    protected $primaryKey = 'id';

    // Define los campos que son asignables masivamente
    protected $fillable = [
        'nombre',
        'img',
        'slug',
        'descripcion',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_at',
        'updated_at'
    ];

    // Desactiva los timestamps si no los usas
    public $timestamps = true;

    // Relación con la tabla 'paquetes' (una categoría tiene muchos paquetes)
    public function paquetes()
    {
        return $this->hasMany(Paquetes::class, 'categoria_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
