<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use App\Models\Categoria;
use App\Models\datos_empresa;
use App\Models\Pagina;
use App\Models\Paquetes;
use App\Models\Reservas;
use App\Models\Testimonios;
use Illuminate\Http\Request;

class WebController extends Controller
{
    protected function navPackages()
    {
        $tours = Paquetes::query()->publicados()->where('tipo', 'tour')->with('categoria')->orderByDesc('id')->get();
        $paquetes = Paquetes::query()->publicados()->where('tipo', 'paquete')->with('categoria')->orderByDesc('id')->get();

        return compact('tours', 'paquetes');
    }

    protected function categoriasUnicas()
    {
        return Categoria::query()
            ->orderBy('nombre')
            ->get()
            ->unique('nombre')
            ->values();
    }

    protected function packageDetailRelations(): array
    {
        return ['categoria', 'galeria', 'incluye', 'itinerarios'];
    }

    public function index()
    {
        $datos = datos_empresa::first();
        $carrusels = Carrusel::orderByDesc('id')->get();
        $tours = Paquetes::query()->publicados()->where('tipo', 'tour')->orderByDesc('id')->get();
        $categorias = Categoria::orderByDesc('id')->get();
        $diferentes = Paquetes::query()
            ->publicados()
            ->where('tipo', 'diferente')
            ->with(['galeria' => fn ($q) => $q->limit(3)])
            ->orderByDesc('id')
            ->get();

        $todos = Paquetes::query()->publicados()->orderByDesc('id')->get();
        $paquetes = Paquetes::query()->publicados()->where('tipo', 'paquete')->orderByDesc('id')->get();
        $testimonios = Testimonios::where('estado', 'activo')->orderByDesc('id')->get();

        return view('index', compact('datos', 'tours', 'carrusels', 'categorias', 'diferentes', 'testimonios', 'todos', 'paquetes'));
    }

    public function tours()
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $toursList = Paquetes::query()->publicados()->where('tipo', 'tour')->with('categoria')->orderByDesc('id')->paginate(12);
        $categorias = $this->categoriasUnicas();

        return view('tours', [
            'datos' => $datos,
            'tours' => $toursList,
            'paquetes' => $paquetes,
            'categorias' => $categorias,
            'navTours' => $tours,
        ]);
    }

    public function toursdetalle(Request $request, $slug)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();
        $categorias = $this->categoriasUnicas();

        return view('detalle', compact('datos', 'tours', 'paquetes', 'tour', 'categorias'));
    }

    public function caminatas()
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $caminatas = Paquetes::query()
            ->publicados()
            ->whereIn('tipo', ['caminata', 'treks'])
            ->with('categoria')
            ->orderByDesc('id')
            ->paginate(12);

        return view('caminatas', compact('datos', 'tours', 'paquetes', 'caminatas'));
    }

    public function caminatadetalle(Request $request, $slug)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();
        $categorias = $this->categoriasUnicas();

        return view('detalle', compact('datos', 'tours', 'paquetes', 'tour', 'categorias'));
    }

    public function paquetes()
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $paquetesList = Paquetes::query()->publicados()->where('tipo', 'paquete')->with('categoria')->orderByDesc('id')->paginate(12);

        return view('paquetes', [
            'datos' => $datos,
            'tours' => $tours,
            'paquetes' => $paquetesList,
        ]);
    }

    public function paquetesdetalle(Request $request, $slug)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();
        $categorias = $this->categoriasUnicas();

        return view('detalle', compact('datos', 'tours', 'paquetes', 'tour', 'categorias'));
    }

    public function contactos()
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $pagina = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('paginas')) {
            $pagina = Pagina::query()->publicadas()->where('slug', 'contacto')->first();
        }

        return view('contacto', compact('datos', 'tours', 'paquetes', 'pagina'));
    }

    public function categorias($slug)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $categoria = Categoria::where('slug', $slug)->firstOrFail();
        $toursList = Paquetes::query()
            ->publicados()
            ->where('categoria_id', $categoria->id)
            ->with('categoria')
            ->orderByDesc('id')
            ->paginate(12);

        return view('categorias', [
            'datos' => $datos,
            'tours' => $toursList,
            'paquetes' => $paquetes,
            'categoria' => $categoria,
            'navTours' => $tours,
        ]);
    }

    public function pagina(string $slug)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());
        $pagina = Pagina::query()->publicadas()->where('slug', $slug)->firstOrFail();

        return view('pagina', compact('datos', 'tours', 'paquetes', 'pagina'));
    }

    public function reservas(Request $request)
    {
        $request->validate([
            'paquete_id' => 'required',
            'cliente' => 'required',
            'email' => 'required|email',
            'comentario' => 'nullable',
            'cantidad_personas' => 'required|integer|min:1',
            'fecha_reserva' => 'required|date',
        ]);

        $reserva = new Reservas();
        $reserva->paquete_id = $request->input('paquete_id');
        $reserva->cliente = $request->input('cliente');
        $reserva->email = $request->input('email');
        $reserva->comentario = $request->input('comentario');
        $reserva->cantidad_personas = $request->input('cantidad_personas');
        $reserva->fecha_reserva = $request->input('fecha_reserva');
        $reserva->estado = 'pendiente';
        $reserva->save();

        return redirect()->back()->with('success', 'Reserva realizada con éxito.');
    }

    public function login()
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());

        return view('login', compact('datos', 'tours', 'paquetes'));
    }

    public function register(Request $request)
    {
        $datos = datos_empresa::first();
        extract($this->navPackages());

        return view('register', compact('datos', 'tours', 'paquetes'));
    }
}
