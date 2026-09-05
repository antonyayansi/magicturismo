<?php

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('tours', [WebController::class, 'tours'])->name('tours');
Route::get('tours/{slug}', [WebController::class, 'toursdetalle'])->name('toursdetalle');
Route::get('caminatas', [WebController::class, 'caminatas'])->name('caminatas');
Route::get('caminatas/{slug}', [WebController::class, 'caminatadetalle'])->name('caminatadetalle');
Route::get('paquetes', [WebController::class, 'paquetes'])->name('paquetes');
Route::get('paquetes/{slug}', [WebController::class, 'paquetesdetalle'])->name('paquetesdetalle');
Route::get('diferente', [WebController::class, 'diferentes'])->name('diferente');
Route::get('categorias/{slug}', [WebController::class, 'categorias'])->name('categorias');
Route::get('categorias/{slug}/{slug2}', [WebController::class, 'categoriasdetalle'])->name('categoriasdetalle');

Route::post('reservas', [WebController::class, 'reservas'])->middleware('throttle:8,1')->name('reservas');

Route::get('contacto', [WebController::class, 'contactos'])->name('contacto');
Route::get('login', [WebController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'login'])->middleware('throttle:10,1')->name('login.post');
Route::get('register', [WebController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'register'])->middleware('throttle:5,1')->name('register.post');
Route::get('logout', [UsersController::class, 'logout'])->name('logout');

Route::get('responsabilidad', [TiendaController::class, 'index'])->name('responsabilidad');

Route::get('sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
Route::get('{slug}', [WebController::class, 'pagina'])
    ->name('cms.pagina')
    ->where('slug', '^(?!admin$|tours$|caminatas$|paquetes$|categorias$|contacto$|login$|register$|responsabilidad$|reservas$|logout$|diferente$|pagina$|livewire$).+');
