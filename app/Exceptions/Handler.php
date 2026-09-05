<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\datos_empresa;
use App\Models\Paquetes;
use App\Models\Categoria;
use Throwable;
use Appp\Models\Tour;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            // Carga los tours desde la base de datos
            $datos = datos_empresa::first();
            $tours = Paquetes::where('tipo', 'tour')->orderBy('id', 'desc')->get();
            $categorias = Categoria::orderBy('id', 'desc')->get();
            $diferentes = Paquetes::where('tipo', 'diferente')->orderBy('id', 'desc')->get();
            $paquetes = Paquetes::orderBy('id', 'desc')->limit(10)->get();

            return response()->view('errors.404', compact('datos', 'tours', 'categorias', 'diferentes', 'paquetes'), 404);
        });
    }
}
