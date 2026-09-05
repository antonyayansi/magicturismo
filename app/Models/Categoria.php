<?php

namespace App\Models;

use App\Services\SiteSettings;
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

    public $timestamps = true;

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::forget());
        static::deleted(fn () => SiteSettings::forget());
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: ('Categoría '.$this->nombre.' | Magic Journeys Peru');
    }

    public function seoDescription(): string
    {
        return $this->meta_description ?: ($this->descripcion ?: ('Tours y paquetes de la categoría '.$this->nombre.'.'));
    }

    // Relación con la tabla 'paquetes' (una categoría tiene muchos paquetes)
    public function paquetes()
    {
        return $this->hasMany(Paquetes::class, 'categoria_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
