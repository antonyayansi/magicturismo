@extends('layout.es')
@php
    $heading = $pageHeading ?? \App\Models\Contenido::texto('listados.tours_titulo', 'Nuestros Tours');
    $metaTitle = $pageTitle ?? \App\Models\Contenido::texto('listados.tours_meta_title', 'Tours | Magic Journeys Peru');
    $metaDesc = $pageDescription ?? \App\Models\Contenido::texto('listados.tours_meta_description', 'Descubre nuestros tours en Cusco y el Perú.');
@endphp
@section('titulo', $metaTitle)
@section('palabras', \App\Models\Contenido::texto('listados.tours_meta_keywords', ''))
@section('descripcion', $metaDesc)
@section('contenido')

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $heading }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $heading }}</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="space">
        <div class="container">

            <div class="row">
                <div class="col-xxl-12 col-lg-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel"
                            aria-labelledby="tab-tour-grid">
                            <div class="row gy-24 gx-24">
                                @foreach ($tours as $tour)
                                    <div class="col-md-3">
                                        <div class="tour-box th-ani">
                                            <div class="tour-box_img global-img">
                                                <img src="{{ Storage::url($tour->imagen) }}" alt="{{ $tour->titulo }}" loading="lazy">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="{{ $tour->publicUrl() }}">{{ $tour->titulo }}</a>
                                                </h3>
                                                
                                                <h4 class="tour-box_price">
                                                    <span class="currency">${{ $tour->precio }}</span>/Persona
                                                </h4>
                                                <div class="tour-action">
                                                    <span>
                                                        <i class="fa-light fa-clock"></i>{{ $tour->duracion }}
                                                    </span>
                                                    <a href="{{ $tour->publicUrl() }}" class="th-btn style4">Ver Detalle</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        {{ $tours->links('vendor.pagination.custom') }}


                    </div>
                </div>


            </div>
            <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="7%" data-right="-8%"><img
                    src="{{ asset('assets/img/shape/shape_1.png') }}" alt="shape"></div>
            <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="1%" data-right="-7%"><img
                    src="{{ asset('assets/img/shape/shape_2.png') }}" alt="shape"></div>
            <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="-2%" data-right="-12%"><img
                    src="{{ asset('assets/img/shape/shape_3.png') }}" alt="shape"></div>
        </div>
    </section>

@endsection
