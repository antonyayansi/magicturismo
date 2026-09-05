<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use App\Models\Categoria;
use App\Models\datos_empresa;
use App\Models\Paquetes;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index()
    {   
        $datos = datos_empresa::first();
        $carrusels = Carrusel::orderBy('id', 'desc')->get();
        $tours = Paquetes::where('tipo', 'tour')->orderBy('id', 'desc')->get();
        $categorias = Categoria::orderBy('id', 'desc')->get();
        $diferentes = Paquetes::where('tipo', 'diferente')->orderBy('id', 'desc')->get();

        $todos = Paquetes::get();
        $paquetes = Paquetes::orderBy('id', 'desc')->where('tipo', 'paquete')->get();

        // Aquí puedes agregar la lógica para mostrar la página de responsabilidad social
        return view('tienda', compact('datos', 'tours', 'carrusels', 'categorias', 'diferentes', 'todos', 'paquetes'));
    }
}
