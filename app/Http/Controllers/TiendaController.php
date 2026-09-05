<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Services\SiteSettings;

class TiendaController extends Controller
{
    public function index()
    {
        $pagina = null;
        if (\App\Support\SchemaCache::hasTable('paginas')) {
            $pagina = Pagina::query()->publicadas()->where('slug', 'responsabilidad')->first();
        }

        return view('tienda', [
            'datos' => SiteSettings::datos(),
            'pagina' => $pagina,
        ]);
    }
}
