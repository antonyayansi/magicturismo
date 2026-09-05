@extends('layout.es')
@section('titulo', 'Sobre nosotros')
@section('palabras')
@section('descripcion')
@section('contenido')

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Nosotros</h1>
                <ul class="breadcumb-menu">
                    <li><a href="home-travel.html">Home</a></li>
                    <li>Nosotros</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-7">
                    <div class="img-box3">
                        <div class="img1"><img src="{{ asset('assets/img/VIERNES_SANTO.png') }}" alt="About"></div>
                        <div class="img2"><img src="assets/img/normal/about_3_2.jpg" alt="About"></div>
                        <div class="img3 movingX"><img src="assets/img/normal/about_3_3.jpg" alt="About"></div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20"><span class="sub-title style1">Bienvenido a Magic Journeys</span>
                            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">Vive, explora y descubre el mundo con nosotros.
                            </h2>
                        </div>
                        <p class="pe-xl-5">Somos una agencia de viajes reconocida a nivel mundial, especializada en ofrecer experiencias inolvidables a nuestros clientes.</p>
                        <p class="mb-30 pe-xl-5">Existen muchas formas de viajar, pero la mayoría de experiencias comunes han sido afectadas por servicios poco personalizados. En Tourm, nos enfocamos en brindarte aventuras auténticas, cuidadosamente diseñadas para que cada momento cuente.</p>
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
                        <div class="mt-35"><a href="contact.html" class="th-btn style3 th-icon">Contact With Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection