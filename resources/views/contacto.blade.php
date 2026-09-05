@extends('layout.es')
@php
    $pageTitle = optional($pagina)->meta_title ?: optional($pagina)->titulo ?: 'Sobre nosotros';
    $pageDesc = optional($pagina)->meta_description ?: optional($pagina)->extracto ?: '';
    $pageKeys = optional($pagina)->meta_keywords ?: '';
@endphp
@section('titulo', $pageTitle)
@section('palabras', $pageKeys)
@section('descripcion', $pageDesc)
@section('contenido')

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ optional($pagina)->titulo ?? 'Nosotros' }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>{{ optional($pagina)->titulo ?? 'Nosotros' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-7">
                    <div class="img-box3">
                        <div class="img1"><img src="{{ optional($pagina)->imagen ? Storage::url($pagina->imagen) : \App\Models\Contenido::imagenUrl('contacto.img1', asset('assets/img/normal/about_3_1.jpg')) }}" alt="About" loading="lazy"></div>
                        <div class="img2"><img src="{{ \App\Models\Contenido::imagenUrl('contacto.img2', asset('assets/img/normal/about_3_2.jpg')) }}" alt="About" loading="lazy"></div>
                        <div class="img3 movingX"><img src="{{ \App\Models\Contenido::imagenUrl('contacto.img3', asset('assets/img/normal/about_3_3.jpg')) }}" alt="About" loading="lazy"></div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20"><span class="sub-title style1">@contenido('contacto.subtitulo', 'Bienvenido a Magic Journeys')</span>
                            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">@contenido('contacto.titulo', 'Vive, explora y descubre el mundo con nosotros.')
                            </h2>
                        </div>
                        <p class="pe-xl-5">@contenido('contacto.parrafo1', 'Somos una agencia de viajes reconocida a nivel mundial, especializada en ofrecer experiencias inolvidables a nuestros clientes.')</p>
                        <p class="mb-30 pe-xl-5">@contenido('contacto.parrafo2', 'Existen muchas formas de viajar, pero la mayoría de experiencias comunes han sido afectadas por servicios poco personalizados. En Magic Journeys nos enfocamos en brindarte aventuras auténticas, cuidadosamente diseñadas para que cada momento cuente.')</p>
                        @if(!empty(optional($pagina)->contenido))
                            <div class="mb-30 pe-xl-5">{!! $pagina->contenido !!}</div>
                        @endif
                        <div class="about-item-wrap">
                            <div class="about-item style2">
                                <div class="about-item_img"><img src="assets/img/icon/about_1_1.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Viajes Exclusivos</h5>
                                    <p class="about-item_text">Diseñamos paquetes únicos adaptados a tus gustos, intereses y presupuesto. Cada viaje es una experiencia personalizada, pensada solo para ti.</p>
                                </div>
                            </div>
                            <div class="about-item style2">
                                <div class="about-item_img"><img src="assets/img/icon/about_1_2.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Seguridad Primero, Siempre</h5>
                                    <p class="about-item_text">Tu tranquilidad es nuestra prioridad. Cumplimos con todos los estándares internacionales de seguridad y trabajamos con los mejores proveedores para que viajes sin preocupaciones.</p>
                                </div>
                            </div>
                            <div class="about-item style2">
                                <div class="about-item_img"><img src="assets/img/icon/about_1_3.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Guías Profesionales</h5>
                                    <p class="about-item_text">Contamos con guías expertos, apasionados por compartir su conocimiento y hacer de cada recorrido una experiencia enriquecedora y divertida.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-35"><a href="{{ route('contacto') }}" class="th-btn style3 th-icon">Contactanos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
