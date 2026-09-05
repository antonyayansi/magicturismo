@extends('layout.es')
@section('titulo', $tour->seoTitle() . ' | Magic Journeys Peru')
@section('palabras', $tour->meta_keywords ?: '')
@section('descripcion', $tour->seoDescription())
@section('canonical', $tour->canonical_url ?: url()->current())
@section('contenido')
    <script src="https://unpkg.com/@dankira/niubiz/dist/niubiz.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.es);
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#fecha", {
                dateFormat: "Y-m-d",
                minDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                locale: "es"
            });
        });
    </script>
    <style>
        .breadcumb-wrapper {
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            /* Asegura que el texto sea blanco */
        }

        .breadcumb-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* 0.5 es el nivel de oscuridad */
            z-index: 1;
        }

        .breadcumb-content {
            position: relative;
            z-index: 2;
            /* Pone el contenido por encima del overlay */
        }
    </style>
    <div class="breadcumb-wrapper" data-bg-src="{{ Storage::url($tour->imagen) }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $tour->titulo }} </h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ $tour->titulo }} </li>
                </ul>
            </div>
        </div>
    </div>
    <style>
        .tour-slider-img-1 {
            width: 100%;
            height: 600px;
            overflow: hidden;
            border-radius: 10px;
        }

        .tour-slider-img-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Responsivo: pantallas medianas */
        @media (max-width: 992px) {
            .tour-slider-img-1 {
                height: 400px;
            }
        }

        /* Responsivo: pantallas pequeñas */
        @media (max-width: 576px) {
            .tour-slider-img-1 {
                height: 250px;
            }
        }
    </style>

    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="tour-page-single">
                        <div class="slider-area tour-slider1">
                            <div class="swiper th-slider mb-4" id="tourSlider4"
                                data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".tour-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                                <div class="swiper-wrapper">

                                    @foreach ($tour->galeria as $galeria)
                                        <div class="swiper-slide">
                                            <div class="tour-slider-img-1">
                                                <img style="width: 100%;" src="{{ Storage::url($galeria->img) }}" alt="img">
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                            <div class="swiper th-slider tour-thumb-slider"
                                data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"autoplayDisableOnInteraction":"true"}'>
                                <div class="swiper-wrapper">

                                    @foreach ($tour->galeria as $galery)
                                        <div class="swiper-slide">
                                            <div class="tour-slider-img">
                                                <img src="{{ Storage::url($galery->img) }}" alt="Image">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <button data-slider-prev="#tourSlider4" class="slider-arrow style3 slider-prev">
                                <img src="{{ asset('assets/img/icon/hero-arrow-left.svg') }}" alt="">
                            </button>
                            <button data-slider-next="#tourSlider4" class="slider-arrow style3 slider-next">
                                <img src="{{ asset('assets/img/icon/hero-arrow-right.svg') }}" alt="">
                            </button>
                        </div>

                        <div class="page-content">
                            <div class="page-meta mb-45">
                                <a class="page-tag" href="#">{{ $tour->categoria->nombre }}</a>
                                {{-- <span class="ratting">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <span>4.8</span>
                                </span> --}}
                            </div>

                            <div class="border rounded-md p-4 mb-5">
                                {!! $tour->descripcion !!}
                            </div>

                            <div class="destination-checklist">
                                <div class="checklist style1 style4">
                                    <h3>@contenido('detalle.label_incluye', 'Incluye')</h3>
                                    <ul>
                                        @foreach ($tour->incluye as $inclu)
                                            @if ($inclu->tipo == 'incluido')
                                                <li>{{ $inclu->detalle }}</li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div> <br>
                            <div class="destination-checklist ">
                                <div class="checklist style1 style5">
                                    <h3>@contenido('detalle.label_no_incluye', 'No Incluye')</h3>
                                    <ul>
                                        @foreach ($tour->incluye as $inclu)
                                            @if ($inclu->tipo == 'no_incluido')
                                                <li>{{ $inclu->detalle }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="border rounded-md p-4 mt-4 mb-4">
                            <h3 class="page-title mb-0">@contenido('detalle.label_plan', 'Tour Plan')</h3>
                                <ul class="nav nav-tabs tour-tab mt-10" role="tablist">
                                    @foreach ($tour->itinerarios->sortBy('orden') as $index => $itinerario)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="day-tab{{ $index + 1 }}"
                                            data-bs-toggle="tab" data-bs-target="#day-tab{{ $index + 1 }}-pane" type="button"
                                            role="tab" aria-controls="day-tab{{ $index + 1 }}-pane"
                                            aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                            {{ $itinerario->titulo }}
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($tour->itinerarios->sortBy('orden') as $index => $itinerario)
                                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                            id="day-tab{{ $index + 1 }}-pane" role="tabpanel"
                                            aria-labelledby="day-tab{{ $index + 1 }}" tabindex="0">
                                            <div class="tour-grid-plan">
                                                <div class="checklist">
                                                    <ul>
                                                        @foreach (explode("\n", $itinerario->descripcion) as $item)
                                                            <li>{!! $itinerario->desc !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tour-gallery-wrapper p-4 border rounded-md">
                                <h3 class="page-title mb-30">@contenido('detalle.label_galeria', 'Galería')</h3>
                                <div class="row gy-4 gallery-row filter-active">
                                    @foreach ($tour->galeria as $img)
                                        <div class="col-md-4 filter-item">
                                            <div class="tour-gallery-card">
                                                <div class="gallery-img global-img">
                                                    <img src="{{ Storage::url($img->img) }}" alt="gallery image"
                                                        width="100px" />
                                                    <a href="{{ Storage::url($img->img) }}" class="icon-btn popup-image">
                                                        <i class="fal fa-magnifying-glass-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search">
                            <div class="row g-2">
                                <div class="col-12">
                                    <!-- Verificar si hay un mensaje de éxito en la sesión -->
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="bi bi-check-circle-fill me-2"></i>
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <h3 class="widget_title">Reserva tu Tour</h3>
                                    <!-- <div class="tour-price">
                                        <span class="price">Desde</span>
                                        <h2>$ {{$tour->precio}} </h2>
                                        <span class="price">Por Persona</span>
                                        <hr>
                                    </div> -->
                                </div>

                                <div class="col-6">
                                    <a href="#" class="th-btn style3" style="width: 100%;" data-bs-toggle="modal"
                                        data-bs-target="#reservaModal">Reservar</a>
                                </div>

                                <!-- <div class="col-6">
                                    <a href="#" class="th-btn style4" style="width: 100%;" data-bs-toggle="modal"
                                        data-bs-target="#compraModal">Comprar</a>
                                </div> -->
                            </div>
                        </div>

                        <div class="widget widget_categories">
                            <h3 class="widget_title">Categorías</h3>
                            <ul>
                                @foreach ($categorias as $cate)
                                    <li>
                                        <a href="{{ route('categorias', $cate->slug) }}">
                                            <img src="{{ Storage::url('categorias/' . $cate->img) }}" alt="" width="20px"
                                                height="20px">
                                            {{ $cate->nombre }}
                                        </a>
                                        <span>({{ $cate->paquetes->count() }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget">
                            <h3 class="widget_title">Tours Recientes</h3>
                            <div class="recent-post-wrap">
                                @foreach ($tours->take(4)->sortBy('orden') as $tour2)
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="#">
                                                <img src="{{ Storage::url($tour2->imagen) }}" alt="Blog Image">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="post-title">
                                                <a class="text-inherit" href="#">{{ $tour2->titulo }}</a>
                                            </h4>
                                            <small>{{ $tour2->tipo }}</small>

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Categorías</h3>
                            <div class="tagcloud">
                                @foreach ($categorias as $cate)
                                    <a href="{{ route('categorias', $cate->slug) }}">{{ $cate->nombre }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="widget widget_offer" data-bg-src="{{ asset('assets/img/bg/widget_bg_1.jpg') }}">
                            <div class="offer-banner">
                                <div class="offer">
                                    <h6 class="box-title">¿Necesitas ayuda? Estamos aquí para ayudarte.</h6>
                                    <div class="banner-logo"><img src="{{ asset('assets/img/logo2.svg') }}" alt="Tourm">
                                    </div>
                                    <div class="offer">
                                        <h6 class="offer-title">Obtienes soporte en línea</h6><a class="offter-num"
                                            href="#">+51 987 654 321</a>
                                    </div><a href="contact.html" class="th-btn style2 th-icon">Contactarse Ahora</a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            {{-- <div class="location-map">
                <h3 class="page-title mt-45 mb-30">Location</h3>
                <div class="contact-map style3"><iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7310056272386!2d89.2286059153658!3d24.00527418490799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fe9b97badc6151%3A0x30b048c9fb2129bc!2sAngfuztheme!5e0!3m2!1sen!2sbd!4v1651028958211!5m2!1sen!2sbd"
                        allowfullscreen="" loading="lazy"></iframe>
                    <div class="contact-icon"><img src="assets/img/icon/location-dot3.svg" alt=""></div>
                </div>
            </div> --}}

        </div>
    </section>
@endsection

@push('modales')
    <!-- Modal de Reservas -->
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('fecha').min = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().split(
            'T')[0];

            const niubiz = window.Niubiz; // <- tu paquete exportado en UMD

            niubiz.setInitialConfig({
                production: false,
                VISA_DEV_MERCHANT_ID: '456879852',
                VISA_DEV_USER: 'integraciones@niubiz.com.pe',
                VISA_DEV_PWD: '_7z3@8fF',
                VISA_PROD_MERCHANT_ID: '', // Producción
                VISA_PROD_USER: '', // Producción
                VISA_PROD_PWD: '', // Producción
                responseUrl: '/success',
            });

            niubiz.setPaymentConfig({
                amount: {{ $tour->precio }},
                currency: 'PEN',
                orderId: 'ORDER123456'
            });

            niubiz.setup();
        });
    </script>
    <div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffffff;">
                    <h5 class="modal-title" id="reservaModalLabel" style="text-transform: uppercase">Formulario de
                        Reserva para el {{ $tour->tipo }} - {{ $tour->titulo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reservas') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="cliente" required
                                    placeholder="Nombre completo">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="Correo electrónico">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="fecha" class="form-label">Fecha de reserva</label>
                                <input type="text" class="form-control" id="fecha" name="fecha_reserva" required
                                    placeholder="Selecciona una fecha">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="personas" class="form-label">Número de personas</label>
                                <input type="number" class="form-control" id="personas" name="cantidad_personas" min="1"
                                    required placeholder="Número de personas">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="comentarios" class="form-label">Comentarios adicionales</label>
                                <textarea class="form-control" id="comentarios" name="comentario" rows="4"
                                    placeholder="Comentarios Adicionales"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="paquete_id" value="{{ $tour->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Enviar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="compraModal" tabindex="-1" aria-labelledby="compraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffffff;">
                    <h5 class="modal-title" id="compraModalLabel" style="text-transform: uppercase">Compra para
                        {{ $tour->tipo }} - {{ $tour->titulo }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (Auth::user() == null)
                        <div style="justify-content: center; display: flex;">
                            <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión para comprar</a>
                        </div>
                    @else
                        <div style="justify-content: center; display: flex;">
                            <form id="frmVisaNet" method="POST" action=""></form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endpush