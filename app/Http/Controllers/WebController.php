<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Contenido;
use App\Models\Pagina;
use App\Models\Paquetes;
use App\Models\Reservas;
use App\Services\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class WebController extends Controller
{
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

    protected function applyCatalogFilters($query, Request $request)
    {
        if ($destino = trim((string) $request->query('destino'))) {
            $query->where(function ($q) use ($destino) {
                $q->where('ubicacion', 'like', '%'.$destino.'%')
                    ->orWhere('titulo', 'like', '%'.$destino.'%');
            });
        }

        if ($duracion = trim((string) $request->query('duracion'))) {
            $query->where(function ($q) use ($duracion) {
                $q->where('duracion', 'like', $duracion.'%')
                    ->orWhere('duracion', 'like', '%'.$duracion.' %')
                    ->orWhere('duracion', 'like', '%'.$duracion.'d%');
            });
        }

        return $query;
    }

    protected function catalogQuery(array $tipos, Request $request)
    {
        $query = Paquetes::query()->publicados()->with('categoria');

        if ($tipos !== []) {
            $query->whereIn('tipo', $tipos);
        }

        return $this->applyCatalogFilters($query, $request)->orderByDesc('id');
    }

    public function index()
    {
        return view('index', [
            'datos' => SiteSettings::datos(),
            'carrusels' => SiteSettings::homeCarrusels(),
            'tours' => SiteSettings::homeTours(),
            'categorias' => SiteSettings::categorias(),
            'diferentes' => SiteSettings::homeDiferentes(),
            'todos' => SiteSettings::homeTodos(),
            'paquetes' => SiteSettings::homePaquetes(),
            'testimonios' => SiteSettings::homeTestimonios(),
            'destinos' => SiteSettings::destinos(),
        ]);
    }

    public function tours(Request $request)
    {
        return view('tours', [
            'datos' => SiteSettings::datos(),
            'tours' => $this->catalogQuery(['tour'], $request)->paginate(12)->withQueryString(),
            'categorias' => $this->categoriasUnicas(),
            'destinos' => SiteSettings::destinos(),
        ]);
    }

    public function toursdetalle(string $slug)
    {
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();

        return view('detalle', $this->detallePayload($tour));
    }

    public function caminatas(Request $request)
    {
        return view('caminatas', [
            'datos' => SiteSettings::datos(),
            'caminatas' => $this->catalogQuery(['caminata', 'treks'], $request)->paginate(12)->withQueryString(),
        ]);
    }

    public function caminatadetalle(string $slug)
    {
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();

        return view('detalle', $this->detallePayload($tour));
    }

    public function paquetes(Request $request)
    {
        return view('paquetes', [
            'datos' => SiteSettings::datos(),
            'paquetes' => $this->catalogQuery(['paquete'], $request)->paginate(12)->withQueryString(),
        ]);
    }

    public function paquetesdetalle(string $slug)
    {
        $tour = Paquetes::where('slug', $slug)->with($this->packageDetailRelations())->firstOrFail();

        return view('detalle', $this->detallePayload($tour));
    }

    public function diferentes(Request $request)
    {
        return view('tours', [
            'datos' => SiteSettings::datos(),
            'tours' => $this->catalogQuery(['diferente'], $request)->paginate(12)->withQueryString(),
            'categorias' => $this->categoriasUnicas(),
            'pageTitle' => Contenido::texto('listados.diferente_meta_title', 'Algo diferente | Magic Journeys Peru'),
            'pageDescription' => Contenido::texto('listados.diferente_meta_description', 'Experiencias distintas en Cusco y el Perú.'),
            'pageHeading' => Contenido::texto('listados.diferente_titulo', 'Algo diferente'),
        ]);
    }

    public function contactos()
    {
        $pagina = null;
        if (Schema::hasTable('paginas')) {
            $pagina = Pagina::query()->publicadas()->where('slug', 'contacto')->first();
        }

        return view('contacto', [
            'datos' => SiteSettings::datos(),
            'pagina' => $pagina,
        ]);
    }

    public function categorias(string $slug)
    {
        $categoria = Categoria::where('slug', $slug)->firstOrFail();

        return view('categorias', [
            'datos' => SiteSettings::datos(),
            'categoria' => $categoria,
            'tours' => Paquetes::query()
                ->publicados()
                ->where('categoria_id', $categoria->id)
                ->with('categoria')
                ->orderByDesc('id')
                ->paginate(12)
                ->withQueryString(),
        ]);
    }

    public function categoriasdetalle(string $slug, string $slug2)
    {
        $categoria = Categoria::where('slug', $slug)->firstOrFail();
        $tour = Paquetes::query()
            ->where('slug', $slug2)
            ->where('categoria_id', $categoria->id)
            ->with($this->packageDetailRelations())
            ->firstOrFail();

        return view('detalle', $this->detallePayload($tour));
    }

    protected function detallePayload(Paquetes $tour): array
    {
        return [
            'datos' => SiteSettings::datos(),
            'tour' => $tour,
            'categorias' => SiteSettings::categorias(),
            'recientes' => SiteSettings::navTours(),
        ];
    }

    public function pagina(string $slug)
    {
        $canonicas = [
            'contacto' => 'contacto',
            'responsabilidad' => 'responsabilidad',
            'tours' => 'tours',
            'paquetes' => 'paquetes',
            'caminatas' => 'caminatas',
        ];
        if (isset($canonicas[$slug])) {
            return redirect()->route($canonicas[$slug], [], 301);
        }

        $reservadas = [
            'admin', 'login', 'register', 'reservas', 'logout',
            'pagina', 'diferente', 'sitemap.xml',
        ];

        abort_if(in_array($slug, $reservadas, true), 404);

        $pagina = Pagina::query()->publicadas()->where('slug', $slug)->firstOrFail();

        return view('pagina', [
            'datos' => SiteSettings::datos(),
            'pagina' => $pagina,
        ]);
    }

    public function reservas(Request $request)
    {
        $request->validate([
            'paquete_id' => 'required|integer',
            'cliente' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comentario' => 'nullable|string|max:2000',
            'cantidad_personas' => 'required|integer|min:1|max:50',
            'fecha_reserva' => 'required|date|after_or_equal:today',
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
        return view('login', ['datos' => SiteSettings::datos()]);
    }

    public function register()
    {
        return view('register', ['datos' => SiteSettings::datos()]);
    }
}
