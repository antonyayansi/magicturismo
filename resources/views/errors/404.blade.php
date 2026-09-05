@extends('layout.es')
@section('titulo', 'Magic Tours Cusco')
@section('palabras')
@section('descripcion')
@section('contenido')
<div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Error 404</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Pagina no encontrada</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="space bg-smoke">
        <div class="container">
            <div class="row flex-row-reverse align-items-center">
                <div class="col-lg-6">
                    <div class="error-content">
                        <h2 class="error-title">Oops! Pagina no encontrada</h2>
                        <h4 class="error-subtitle">Parace que esta pagina esta en mantenimiento.</h4>
                        <p class="error-text">Lamentamos cualquier inconveniente. Por favor, regrese más tarde.</p><a href="/" class="th-btn style3"><img
                                src="assets/img/icon/right-arrow2.svg" alt="">Regresar a Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
