<?php

namespace App\Models;

use App\Services\SiteSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Carrusel extends Model
{
    use HasFactory;

    protected $table = 'carrusel';

    protected $fillable = [
        'tipo',
        'url',
        'titulo',
        'subtitulo',
        'texto',
        'boton',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::forget());
        static::deleted(fn () => SiteSettings::forget());
    }

    public function isVideo(): bool
    {
        if ($this->tipo === 'video') {
            return true;
        }

        return (bool) preg_match('/\.(mp4|webm|mov|avi)(\?|$)/i', (string) $this->url);
    }

    public function mediaUrl(): string
    {
        $url = trim((string) $this->url);

        if ($url === '') {
            return '';
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_contains($url, '/')) {
            return Storage::url($url);
        }

        return Storage::url('carrusel/'.$url);
    }
}
