<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Services\SiteSettings;
use Illuminate\Support\Facades\Schema;

class TiendaController extends Controller
{
    public function index()
    {
        $pagina = null;
        if (Schema::hasTable('paginas')) {
            $pagina = Pagina::query()->publicadas()->where('slug', 'responsabilidad')->first();
        }

        return view('tienda', [
            'datos' => SiteSettings::datos(),
            'pagina' => $pagina,
        ]);
    }
}
