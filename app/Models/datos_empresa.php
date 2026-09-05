<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datos_empresa extends Model
{
    use HasFactory;
    protected $table = 'datos_empresa';

    // Define la clave primaria (opcional si es 'id')
    protected $primaryKey = 'id';

    // Define los campos que son asignables masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'telefono2',
        'email',
        'email2',
        'horario',
        'logo',
        'favicon',
        'desc_corto',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'whatsapp',
        'youtube',
        'footer_texto',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'url_frances',
        'copyright',
        'faq_url',
        'soporte_url',
        'created_at',
        'updated_at'
    ];

    protected static function booted(): void
    {
        static::saved(fn () => \App\Services\SiteSettings::forget());
        static::deleted(fn () => \App\Services\SiteSettings::forget());
    }


    // Especifica si necesitas un formato de fecha personalizado
    protected $dates = ['created_at', 'updated_at'];
}
