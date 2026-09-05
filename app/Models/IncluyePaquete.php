<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncluyePaquete extends Model
{
    use HasFactory;
    protected $table = 'incluye_paquete';

    protected $primaryKey = 'id';

    protected $fillable = [
        'paquete_id',
        'detalle',
        'tipo',
        'estado',
        'created_at',
        'updated_at'
    ];


    public function paquete()
    {
        return $this->belongsTo(Paquetes::class, 'paquete_id');
    }

    protected $dates = ['created_at', 'updated_at'];
}
