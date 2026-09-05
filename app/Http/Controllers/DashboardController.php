<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use App\Models\GaleriaPaq;
use App\Models\Paquetes;
use App\Models\Categoria;
use App\Models\ItinerarioPaquete;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class DashboardController extends Controller
{

    public function reservas(){
        $reservas = DB::table('reservas')
            ->join('paquetes', 'reservas.paquete_id', '=', 'paquetes.id')
            ->select('reservas.*', 'paquetes.titulo')
            ->orderBy('reservas.id', 'desc')
            ->simplepaginate(15);
            
        return view('admin.reservas.index', compact('reservas'));
    }

    public function index()
    {
        $paquetes = Paquetes::where('tipo', 'paquete')->get();
        $caminatas = Paquetes::where('tipo', 'treks')->get();
        $tours = Paquetes::where('tipo', 'tour')->get();
        $categorias = Categoria::all();
        return view('admin.index', compact('paquetes', 'caminatas', 'tours', 'categorias'));
    }

    public function paquetes()
    {
        $paquetes = Paquetes::simplepaginate(15);

        return view('admin.paquetes', compact('paquetes'));
    }

    public function search(Request $request)
    {
        // Recuperar el valor de búsqueda
        $search = $request->input('search');

        // Realizar la consulta para buscar paquetes que coincidan con el término
        $paquetes = Paquetes::where('titulo', 'LIKE', '%' . $search . '%')
            ->orWhere('descripcion', 'LIKE', '%' . $search . '%')
            ->simplepaginate(15);

        // Retornar la vista con los resultados
        return view('admin.paquetes', compact('paquetes'));
    }

    //crear paquete
    public function create_paquete()
    {
        $categorias = Categoria::all();

        return view('admin.create_paquete', compact('categorias'));
    }
    public function store_paquete(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif|max:2048', // Validación de imagen
            'adj_video' => 'nullable|mimes:mp4,avi,mkv|max:10240', // Validación de video
            'adj_pdf' => 'nullable|mimes:pdf|max:2048', // Validación de PDF
        ]);

        // Guardar los datos generales
        $slug = Str::slug($request->titulo);
        $paquete = new Paquetes();
        $paquete->titulo = $request->titulo;
        $paquete->duracion = $request->duracion;
        $paquete->can_personas = $request->can_personas;
        $paquete->tipo = $request->tipo;
        $paquete->dificultad = $request->dificultad;
        $paquete->estado = $request->estado;
        $paquete->categoria_id = $request->categoria_id;
        $paquete->altitud = $request->altitud;
        $paquete->ubicacion = $request->ubicacion;
        $paquete->precio = $request->precio;
        $paquete->descripcion = $request->descripcion;
        $paquete->slug = $slug;

        // Subir la imagen (si existe)
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $imagenName = $imagen->getClientOriginalName(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'paquetes' si es necesario
            $imagen->storeAs('public/paquetes', $imagenName); // Guardar el archivo con el nombre original
            $paquete->imagen = $imagenName; // Guardar solo el nombre del archivo
        }

        // Subir el video (si existe)
        if ($request->hasFile('adj_video')) {
            $video = $request->file('adj_video');
            $videoName = $video->getClientOriginalName(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'videos' si es necesario
            $video->storeAs('public/videos', $videoName); // Guardar el archivo con el nombre original
            $paquete->adj_video = $videoName; // Guardar solo el nombre del archivo
        }

        // Subir el PDF (si existe)
        if ($request->hasFile('adj_pdf')) {
            $pdf = $request->file('adj_pdf');
            $pdfName = $pdf->getClientOriginalName(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'documentos' si es necesario
            $pdf->storeAs('public/documentos', $pdfName); // Guardar el archivo con el nombre original
            $paquete->adj_pdf = $pdfName; // Guardar solo el nombre del archivo
        }


        // Guardar el paquete en la base de datos
        $paquete->save();

        return redirect()->route('admin.paquetes')->with('success', 'Paquete creado correctamente.');
    }
    public function editar_paquete($id)
    {
        $paquete = Paquetes::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.edit_paquete', compact('paquete', 'categorias'));
    }

    public function update_paquete(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg', // Validación de imagen
            'adj_video' => 'nullable|mimes',
            'adj_pdf' => 'nullable|mimes:pdf|max:2048', // Validación de PDF
        ]);
        // Buscar el paquete por ID
        $paquete = Paquetes::findOrFail($id);
        // Actualizar los datos generales
        $paquete->titulo = $request->titulo;
        $paquete->duracion = $request->duracion;
        $paquete->can_personas = $request->can_personas;
        $paquete->tipo = $request->tipo;
        $paquete->dificultad = $request->dificultad;
        $paquete->estado = $request->estado;
        $paquete->categoria_id = $request->categoria_id;
        $paquete->altitud = $request->altitud;
        $paquete->ubicacion = $request->ubicacion;
        $paquete->precio = $request->precio;
        $paquete->descripcion = $request->descripcion;

        //dd($request->imagen);
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $imagenName = $imagen->getClientOriginalName(); // Obtener solo el nombre del archivo
            $imagen->storeAs('public/paquetes', $imagenName); // Guardar el archivo con el nombre original
            $paquete->imagen = $imagenName; // Guardar solo el nombre del archivo
        }
        // Subir el video (si existe)
        if ($request->hasFile('adj_video')) {
            $video = $request->file('adj_video');
            $videoName = $video->getClientOriginalName(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'videos' si es necesario
            $video->storeAs('public/videos', $videoName); // Guardar el archivo con el nombre original
            $paquete->adj_video = $videoName; // Guardar solo el nombre del archivo
        }
        // Subir el PDF (si existe)
        if ($request->hasFile('adj_pdf')) {
            $pdf = $request->file('adj_pdf');
            $pdfName = $pdf->getClientOriginalName(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'documentos' si es necesario
            $pdf->storeAs('public/documentos', $pdfName); // Guardar el archivo con el nombre original
            $paquete->adj_pdf = $pdfName; // Guardar solo el nombre del archivo
        }
        // Guardar el paquete en la base de datos
        $paquete->save();
        return redirect()->route('admin.paquetes')->with('success', 'Paquete actualizado correctamente.');
    }

    public function destroy_paquete($id)
    {
        // Buscar el paquete por ID
        $paquete = Paquetes::findOrFail($id);

        // Eliminar la imagen del almacenamiento (si existe)
        if ($paquete->imagen) {
            Storage::delete('public/paquetes/' . $paquete->imagen);
        }

        // Eliminar el video del almacenamiento (si existe)
        if ($paquete->adj_video) {
            Storage::delete('public/videos/' . $paquete->adj_video);
        }

        // Eliminar el PDF del almacenamiento (si existe)
        if ($paquete->adj_pdf) {
            Storage::delete('public/documentos/' . $paquete->adj_pdf);
        }

        // Eliminar el paquete de la base de datos
        $paquete->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.paquetes')->with('success', 'Paquete eliminado correctamente.');
    }

    //agregar imagenes al paquete
    public function imagenes_paquetes($id)
    {
        $paquete = Paquetes::findOrFail($id);
        $galeria = GaleriaPaq::where('paquete_id', $id)->get();
        return view('admin.galeria_paquete', compact('paquete', 'galeria'));
    }
    public function store_imagenes_paquete(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp,avif,svg',
            'desc' => 'nullable|string|max:255', // Descripción opcional
        ]);

        $paquete = Paquetes::findOrFail($id);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $originalName = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $imagen->getClientOriginalExtension();

            $encryptedName = encrypt($originalName);
            $imagenName = $encryptedName . '.' . $extension;

            if (!Storage::exists('public/paquetes')) {
                Storage::makeDirectory('public/paquetes');
            }

            $imagen->storeAs('public/paquetes', $imagenName);

            $image = $paquete->galeria()->create([
                'img' => $imagenName,
                'desc' => $request->input('desc', null),
            ]);

            //dd($image); 

            return redirect()->route('admin.paquetes.imagenes', ['id' => $id])
                ->with('success', 'Imagen agregada correctamente.');
        } else {
            return redirect()->route('admin.paquetes.imagenes', ['id' => $id])
                ->with('error', 'No se ha seleccionado ninguna imagen.');
        }
    }

    //agregar itinerario al paquete
    public function itinerario_paquete($id)
    {
        $paquete = Paquetes::findOrFail($id);
        $itinerarios = ItinerarioPaquete::where('paquete_id', $id)->orderBy('orden', 'asc')->get();
        return view('admin.itinerario_paquete', compact('paquete', 'itinerarios'));
    }
    public function store_itinerario(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'desc' => 'required|string',
            'orden' => 'required|integer',
        ]);

        $paquete = Paquetes::findOrFail($id);
        $paquete->itinerarios()->create([
            'titulo' => $request->titulo,
            'desc' => $request->desc,
            'orden' => $request->orden,
            'fecha' => Carbon::now(),
        ]);

        return redirect()->route('admin.paquetes.itinerario', ['id' => $id])
            ->with('success', 'Itinerario agregado correctamente.');
    }

    public function update_itinerario(Request $request, $id, $id_itinerario)
    {
        $paquete = Paquetes::findOrFail($id);

        $itinerario = $paquete->itinerarios()->findOrFail($id_itinerario);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'desc' => 'required|string',
            'orden' => 'required|integer',
        ]);

        $itinerario->update([
            'titulo' => $request->input('titulo'),
            'desc' => $request->input('desc'),
            'orden' => $request->input('orden'),
        ]);

        return redirect()->route('admin.paquetes.itinerario', ['id' => $id])
            ->with('success', 'Itinerario actualizado correctamente.');
    }


    public function destroy_itinerario($id, $id_itinerario)
    {
        $paquete = Paquetes::findOrFail($id);
        $itinerario = $paquete->itinerarios()->findOrFail($id_itinerario);
        $itinerario->delete();
        return redirect()->route('admin.paquetes.itinerario', ['id' => $id])->with('success', 'Itinerario eliminado correctamente.');
    }



    public function editar_imagen($id, $id_imagen)
    {
        $paquete = Paquetes::findOrFail($id);
        $imagen = $paquete->imagenes()->findOrFail($id_imagen);
        return view('admin.edit_imagen', compact('paquete', 'imagen'));
    }
    public function update_imagen(Request $request, $id, $id_imagen)
    {
        // Validar los datos del formulario
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de imagen
        ]);

        // Buscar el paquete por ID
        $paquete = Paquetes::findOrFail($id);
        $imagen = $paquete->imagenes()->findOrFail($id_imagen);

        // Subir la imagen (si existe)
        if ($request->hasFile('file')) {
            $newImagen = $request->file('file');
            $newImagenName = time() . '.' . $newImagen->getClientOriginalExtension(); // Obtener solo el nombre del archivo
            // Opcional: mover el archivo a la carpeta 'paquetes' si es necesario
            $newImagen->storeAs('public/paquetes', $newImagenName); // Guardar el archivo con el nombre original

            // Eliminar la imagen anterior del almacenamiento (si existe)
            if ($imagen->url) {
                Storage::delete('public/paquetes/' . $imagen->url);
            }

            // Actualizar la imagen en la base de datos
            $imagen->update(['url' => $newImagenName]); // Guardar solo el nombre del archivo
        }

        return redirect()->route('admin.paquetes.imagenes', ['id' => $id])->with('success', 'Imagen actualizada correctamente.');
    }
    public function destroy_imagen($id, $id_imagen)
    {
        $paquete = Paquetes::findOrFail($id);
        $imagen = $paquete->galeria()->findOrFail($id_imagen);
        if ($imagen->img) {
            Storage::delete('public/paquetes/' . $imagen->img . '.' . pathinfo($imagen->img, PATHINFO_EXTENSION));
        }
        $imagen->delete();
        return redirect()->route('admin.paquetes.imagenes', ['id' => $id])->with('success', 'Imagen eliminada correctamente.');
    }




    public function carrusel()
    {
        $carrusels = Carrusel::orderBy('id', 'asc')->get();
        return view('admin.carrusels', compact('carrusels'));
    }

    public function storeCarrusel(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:video,imagen',
            'file' => 'required|file',
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'texto' => 'nullable|string',
            'url_boton' => 'nullable|url',
        ]);

        $carrusel = new Carrusel();
        $carrusel->tipo = $request->tipo;
        $carrusel->titulo = $request->titulo;
        $carrusel->subtitulo = $request->subtitulo;
        $carrusel->texto = $request->texto;
        $carrusel->boton = $request->url_boton;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/carrusel', $fileName);
            $carrusel->url = $fileName;
        }

        $carrusel->save();

        return redirect()->route('admin.carrusel')->with('success', 'Carrusel agregado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'texto' => 'nullable|string',
            'url_boton' => 'nullable|url',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,avi', // Solo imágenes y videos
        ]);

        $carrusel = Carrusel::findOrFail($id);

        $carrusel->titulo = $request->titulo;
        $carrusel->subtitulo = $request->subtitulo;
        $carrusel->texto = $request->texto;
        $carrusel->boton = $request->url_boton;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/carrusel', $fileName);
            $carrusel->url = $fileName; // Guardar solo el nombre del archivo
        }

        $carrusel->save();

        return redirect()->route('admin.carrusel')->with('success', 'Carrusel actualizado correctamente.');
    }
    public function destroy_carrusel($id)
    {
        $carrusel = Carrusel::findOrFail($id);

        if ($carrusel->file) {
            Storage::delete('public/carrusel/' . $carrusel->file);
        }

        $carrusel->delete();
        return redirect()->route('admin.carrusel')->with('success', 'Carrusel eliminado correctamente.');
    }
}
