<?php

use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('tours', [WebController::class, 'tours'])->name('tours');
Route::get('tours/{slug}', [WebController::class, 'toursdetalle'])->name('toursdetalle');
Route::get('caminatas', [WebController::class, 'caminatas'])->name('caminatas');
Route::get('caminatas/{slug}', [WebController::class, 'caminatadetalle'])->name('caminatadetalle');
Route::get('paquetes', [WebController::class, 'paquetes'])->name('paquetes');
Route::get('paquetes/{slug}', [WebController::class, 'paquetesdetalle'])->name('paquetesdetalle');
/* categorias */
Route::get('categorias/{slug}', [WebController::class, 'categorias'])->name('categorias');
Route::get('categorias/{slug}/{slug2}', [WebController::class, 'categoriasdetalle'])->name('categoriasdetalle');

/* reservas */
Route::post('reservas', [WebController::class, 'reservas'])->name('reservas');

Route::get('contacto', [WebController::class, 'contactos'])->name('contacto');
Route::get('login', [WebController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'login'])->name('login.post');
Route::get('register', [WebController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'register'])->name('register.post');

/* tienda */
Route::get('responsabilidad', [TiendaController::class, 'index'])->name('responsabilidad');


//admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/paquetes', [DashboardController::class, 'paquetes'])->name('admin.paquetes');
    // Route::get('/admin/paquetes/buscar', [DashboardController::class, 'search'])->name('paquetes.search');
    // Route::get('/admin/paquetes/create', [DashboardController::class, 'create_paquete'])->name('admin.create_paquete');
    // Route::post('/admin/paquetes/store', [DashboardController::class, 'store_paquete'])->name('admin.store_paquete');
    // Route::get('/admin/paquetes/{id}/edit', [DashboardController::class, 'editar_paquete'])->name('admin.paquetes.edit');
    // Route::put('/admin/paquetes/{id}/update', [DashboardController::class, 'update_paquete'])->name('admin.paquetes.update');
    // Route::delete('/admin/paquetes/{id}/destroy', [DashboardController::class, 'destroy_paquete'])->name('admin.paquetes.destroy');
    // /* enlaces para agregar imagenes al paquete */
    // Route::get('/admin/paquetes/{id}/imagenes', [DashboardController::class, 'imagenes_paquetes'])->name('admin.paquetes.imagenes');
    // Route::post('/admin/paquetes/{id}/imagenes/store', [DashboardController::class, 'store_imagenes_paquete'])->name('admin.paquetes.imagenes.store');
    // Route::get('/admin/paquetes/{id}/imagenes/{id_imagen}/edit', [DashboardController::class, 'editar_imagen'])->name('admin.paquetes.imagenes.edit');
    // Route::put('/admin/paquetes/{id}/imagenes/{id_imagen}/update', [DashboardController::class, 'update_imagen'])->name('admin.paquetes.imagenes.update');
    // Route::delete('/admin/paquetes/{id}/imagenes/{id_imagen}/destroy', [DashboardController::class, 'destroy_imagen'])->name('admin.paquetes.imagenes.destroy');

    /* enlaces para agregar itinerario al paquete */
    // Route::get('/admin/paquetes/{id}/itinerario', [DashboardController::class, 'itinerario_paquete'])->name('admin.paquetes.itinerario');
    // Route::post('/admin/paquetes/{id}/itinerario/store', [DashboardController::class, 'store_itinerario'])->name('admin.paquetes.itinerario.store');
    // Route::put('/admin/paquetes/{id}/itinerario/{id_itinerario}/update', [DashboardController::class, 'update_itinerario'])->name('admin.paquetes.itinerario.update');
    // Route::delete('/admin/paquetes/{id}/itinerario/{id_itinerario}/destroy', [DashboardController::class, 'destroy_itinerario'])->name('admin.paquetes.itinerario.destroy');

    // Route::get('/admin/carrusel', [DashboardController::class, 'carrusel'])->name('admin.carrusel');
    // Route::post('/admin/carrusel/store', [DashboardController::class, 'storeCarrusel'])->name('admin.carrusel.store');
    // Route::put('/admin/carrusel/{id}/update', [DashboardController::class, 'update'])->name('admin.carrusel.update');
    // Route::delete('/admin/carrusel/{id}/destroy', [DashboardController::class, 'destroy_carrusel'])->name('admin.carrusel.destroy');


});
// Route::get('/admin/paquetes/{id}/edit', [DashboardController::class, 'editar_paquete'])->name('admin.paquetes.edit');
Route::get('logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/foo', function () {
    Artisan::call('storage:link');
});
