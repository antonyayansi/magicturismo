@extends('layout.es')
@section('titulo', 'Categoría '.$categoria->nombre . ' - Magic Tours')
@section('palabras')
@section('descripcion')
@section('contenido')

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Categoría {{ $categoria->nombre }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Categoría {{ $categoria->nombre }}</li>
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
                                @foreach ($tours as $paquete)
                                    <div class="col-md-3">
                                        <div class="tour-box th-ani">
                                            <div class="tour-box_img global-img">
                                                <img src="{{ Storage::url(  $paquete->imagen) }}" alt="image">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="{{ route('paquetesdetalle', ['slug' => $paquete->slug]) }}">{{ $paquete->titulo }}</a>
                                                </h3>
                                                
                                                <h4 class="tour-box_price">
                                                    <span class="currency">${{ $paquete->precio }}</span>/Persona
                                                </h4>
                                                <div class="tour-action">
                                                    <span>
                                                        <i class="fa-light fa-clock"></i>{{ $paquete->duracion }}
                                                    </span>
                                                    <a href="{{ route('paquetesdetalle', ['slug' => $paquete->slug]) }}" class="th-btn style4">Ver Detalle</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        {{ $paquetes->links('vendor.pagination.custom') }}


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
