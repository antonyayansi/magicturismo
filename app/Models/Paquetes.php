<?php

namespace App\Models;

use App\Services\SiteSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquetes extends Model
{
    use HasFactory;
    protected $table = 'paquetes';

    protected $primaryKey = 'id';
    protected $fillable = [
        'titulo',
        'duracion',
        'adj_video',
        'tipo_hotel',
        'can_personas',
        'altitud',
        'tipo',
        'dificultad',
        'estado',
        'adj_pdf',
        'ubicacion',
        'imagen',
        'descripcion',
        'precio',
        'slug',
        'categoria_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'excerpt',
        'created_at',
        'updated_at'
    ];

    public function scopePublicados($query)
    {
        return $query->where(function ($q) {
            $q->where('estado', 'activo')
                ->orWhereNull('estado')
                ->orWhere('estado', '');
        });
    }

    public function scopeDeTipo($query, ...$tipos)
    {
        $tipos = collect($tipos)->flatten()->all();

        return $query->whereIn('tipo', $tipos);
    }

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::forget());
        static::deleted(fn () => SiteSettings::forget());
    }

    public function publicRouteName(): string
    {
        return match ($this->tipo) {
            'paquete' => 'paquetesdetalle',
            'caminata', 'treks' => 'caminatadetalle',
            default => 'toursdetalle',
        };
    }

    public function publicUrl(): string
    {
        return route($this->publicRouteName(), $this->slug);
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->titulo;
    }

    public function seoDescription(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        if ($this->excerpt) {
            return $this->excerpt;
        }

        return \Illuminate\Support\Str::limit(trim(strip_tags((string) $this->descripcion)), 160);
    }

    // Relación con la tabla 'galeria_paq' (un paquete tiene muchas imágenes en la galería)
    public function galeria()
    {
        return $this->hasMany(GaleriaPaq::class, 'paquete_id');
    }

    // Relación con la tabla 'itinerario_paquete' (un paquete tiene muchos itinerarios)
    public function itinerarios()
    {
        return $this->hasMany(ItinerarioPaquete::class, 'paquete_id');
    }

    // Relación con la tabla 'incluye_paquete' (un paquete tiene muchos detalles de inclusión)
    public function incluye()
    {
        return $this->hasMany(IncluyePaquete::class, 'paquete_id');
    }

    // Relación con la tabla 'reservas' (un paquete puede tener muchas reservas)
    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'paquete_id');
    }

    // Relación con la tabla 'valoraciones_paquete' (un paquete puede tener muchas valoraciones)
    public function valoraciones()
    {
        return $this->hasMany(valoraciones_paquete::class, 'paquete_id');
    }

    // Relación con la tabla 'traducciones' (un paquete tiene muchas traducciones en diferentes idiomas)
    public function traducciones()
    {
        return $this->hasMany(traducciones::class, 'paquete_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
