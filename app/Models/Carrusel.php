<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
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

    public function mediaUrl(): ?string
    {
        if (! $this->url) {
            return null;
        }

        if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://')) {
            return $this->url;
        }

        $path = str_contains($this->url, '/') ? $this->url : 'carrusel/'.$this->url;

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}
