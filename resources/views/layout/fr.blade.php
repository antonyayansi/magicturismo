<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <meta name="author" content="cus-code.com - Alex granada Campana">
    <meta name="description" content="@yield('descripcion')">
    <meta name="keywords" content="@yield('palabras')">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" href="{{ asset('assets/img/favicons/icon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Manrope:wght@200..800&amp;family=Montez&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <script>
        function cambiarIdioma(valor) {
            if (valor === 'fr') {
                window.location.href = 'https://voyagesmagiquesperou.com/'; // Ruta a la versión en francés
            } else if (valor === 'es') {
                window.location.href = 'https://magicjourneysperu.com/'; // Ruta a la versión en español
            }
        }

        function cambiarTema(valor) {
            const contenido = document.getElementById('app-contenido');

            if (valor === 'normal') {
                contenido.style.filter = 'none';
                localStorage.setItem('tema', 'normal');
            } else if (valor === 'blanconegro') {
                contenido.style.filter = 'grayscale(100%)';
                localStorage.setItem('tema', 'blanconegro');
            }
        }

        window.addEventListener('load', () => {
            const contenido = document.getElementById('app-contenido');
            const tema = localStorage.getItem('tema');

            contenido.style.filter = (tema === 'blanconegro') ? 'grayscale(100%)' : 'none';
        });
    </script>
    <div id="app-contenido">
        <div id="preloader" class="preloader">
            <!-- <button class="th-btn preloaderCls">Annuler le Préchargeur</button> -->
            <div class="preloader-inner"><img style="width: 220px" src="{{ asset('assets/img/logo_turismo-min.png') }}"
                    alt=""></div>
            <div id="loader" class="th-preloader">
                <div class="animation-preloader">
                    <div class="txt-loading"><span preloader-text="M" class="characters">M </span><span preloader-text="A"
                            class="characters">A </span><span preloader-text="G" class="characters">G </span><span
                            preloader-text="I" class="characters">I </span><span preloader-text="C"
                            class="characters">C</span></div>
                </div>
            </div>
        </div>
        <div class="th-menu-wrapper onepage-nav">
            <div class="th-menu-area text-center"><button class="th-menu-toggle"><i class="fal fa-times"></i></button>
                <div class="mobile-logo"><a href="{{ route('home') }}" width="80px">
                        <img src="{{ asset('assets/img/logo_turismo-min.png') }}" width="150px" alt="Tourm"></a>
                </div>
                <div class="th-mobile-menu">
                    <ul>
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                        </li>
                        <li class="menu-item-has-children"><a href="#">Tours</a>
                            <ul class="sub-menu">
                                @foreach ($tours->take(5) as $tour)
                                    <li><a href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="#">Randonnées</a></li>
                        <li class="menu-item-has-children"><a href="#">Forfaits</a>
                            <ul class="sub-menu">
                                @foreach ($paquetes->take(5) as $paq)
                                    <li><a href="#">{{ $paq->titulo }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="#">Responsabilité sociale</a></li>
                        <li><a href="{{ route('contacto') }}"
                                class="{{ request()->routeIs('about') ? 'active' : '' }}">Contacts - Qui sommes-nous</a></li>
                    </ul>
                </div>
            </div>
        </div>
    
        <header class="th-header header-layout1">
            <div class="header-top">
                <div class="container th-container">
                    <div class="row justify-content-center justify-content-xl-between align-items-center">
                        <div class="col-auto d-none d-md-block">
                            <div class="header-links">
                                <ul>
                                    <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular fa-location-dot"></i>
                                        <span>{{ $datos->direccion }}</span>
                                    </li>
                                    <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock"></i>
                                        <span> {{ $datos->horario }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="header-right">
                                <div class="currency-menu">
                                    <select 
                                        class="form-select nice-select" onchange="cambiarTema(this.value)">
                                        <option selected="">Préférences</option>
                                        <option value="normal">
                                            Normal
                                        </option>
                                        <option value="blanconegro">
                                            Noir et Blanc
                                        </option>
                                    </select>
                                </div>
                                <div class="currency-menu">
                                    <select class="form-select nice-select" onchange="cambiarIdioma(this.value)">
                                        <option selected="">Langue</option>
                                        <option value="es">
                                            ES
                                        </option>
                                    </select>
                                </div>
                                <div class="header-links">
                                    <ul>
                                        <li class="d-none d-md-inline-block"><a href="#">Questions fréquentes</a>
                                        </li>
                                        <li class="d-none d-md-inline-block"><a href="#">Support</a></li>
                                        {{-- <li>
                                            <a href="#login-form" class="popup-content">Se connecter / S'inscrire<i
                                                    class="fa-regular fa-user"></i></a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky-wrapper">
                <div class="menu-area">
                    <div class="container th-container">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <div class="header-logo">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('assets/img/logo_turismo-min.png') }}" alt="Tourm" width="100px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto me-xl-auto " style="margin-left: 120px;">
                                <nav class="main-menu d-none d-xl-inline-block">
                                    <ul>
                                        <li><a href="{{ route('home') }}"
                                                class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a></li>
                                        <li class="menu-item-has-children"><a href="{{ route('tours') }}">Tours</a>
                                            <ul class="sub-menu">
                                                @foreach ($tours->take(5) as $tour)
                                                    <li><a
                                                            href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a>
                                                    </li>
                                                @endforeach
    
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('caminatas') }}">Randonnées</a></li>
                                        <li class="menu-item-has-children"><a href="{{ route('paquetes') }}">Forfaits</a>
                                            <ul class="sub-menu">
                                                @foreach ($paquetes->take(5) as $paq)
                                                    <li><a
                                                            href="{{ route('paquetesdetalle', ['slug' => $paq->slug]) }}">{{ $paq->titulo }}</a>
                                                    </li>
                                                @endforeach
    
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('responsabilidad') }}"
                                                class="{{ request()->routeIs('responsabilidad') ? 'active' : '' }}">
                                                Responsabilité Sociale</a></li>
                                        <li><a href="{{ route('contacto') }}"
                                                class="{{ request()->routeIs('about') ? 'active' : '' }}">Contacts -
                                                Qui sommes-nous</a></li>
                                    </ul>
                                </nav><button type="button" class="th-menu-toggle d-block d-xl-none">
                                    <i class="far fa-bars"></i></button>
                            </div>
                            <div class="col-auto d-none d-xl-block">
                                @if (Auth::user() == null)
                                    <div class="header-button">
                                        <a href="/login" class="th-btn style3 th-icon"> Connexion</a>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <button class="th-btn style4 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            {{ Auth::user()->name }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if(Auth::user()->nivel == 'admin')
                                                <li>
                                                    <a class="dropdown-item" href="/admin">Panneau
                                                        Admin</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="#">Mes achats</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Mes réservations</a></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Se déconnecter</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    
        <main>
            @yield('contenido')
        </main>
    
        <footer class="footer-wrapper footer-layout1">
            <div class="widget-area">
                <div class="container">
                    <div class="newsletter-area">
                        <div class="newsletter-top">
                            <div class="row gy-4 align-items-center">
                                <div class="col-lg-5">
                                    <h2 class="newsletter-title text-capitalize mb-0">Restez informé avec notre dernière newsletter
                                    </h2>
                                </div>
                                <div class="col-lg-7">
                                    <form class="newsletter-form"><input class="form-control" type="email"
                                            placeholder="Entrez votre adresse e-mail" required=""> <button type="submit"
                                            class="th-btn style3">S'abonner <img
                                                src="{{ asset('assets/img/icon/plane.svg') }}" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xl-3">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo"><a href="home-travel.html"><img
                                                src="{{ asset('assets/img/logo_turismo-min.png') }}" alt="Tourm"></a>
                                    </div>
                                    <p class="about-text">Nous créons rapidement des capitaux intellectuels multiplateformes
                                        modèles. Créer de manière appropriée des infrastructures interactives</p>
                                    <div class="th-social"><a href="https://www.facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a href="https://www.twitter.com/"><i
                                                class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a href="https://www.whatsapp.com/"><i
                                                class="fab fa-whatsapp"></i></a> <a href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">Raccourcis</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        <li><a href="/">Accueil</a></li>
                                        <li><a href="/contacto">Qui sommes-nous</a></li>
                                        <li><a href="/tours">Nos Tours</a></li>
                                        <li><a href="/paquetes">Conditions Forfaits</a></li>
                                        <li><a href="/caminatas">Randonnées</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget footer-widget">
                                <h3 class="widget_title">Adresse</h3>
                                <div class="th-widget-contact">
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('assets/img/icon/phone.svg') }}" alt="img">
                                        </div>
                                        <div class="details">
                                            <p><a href="tel:{{ $datos->telefono }}"
                                                    class="info-box_link">{{ $datos->telefono }}</a></p>
                                            <p><a href="tel:{{ $datos->telefono2 }}"
                                                    class="info-box_link">{{ $datos->telefono2 }}</a></p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('assets/img/icon/envelope.svg') }}" alt="img">
                                        </div>
                                        <div class="details">
                                            <p><a href="mailto:{{ $datos->email }}"
                                                    class="info-box_link">{{ $datos->email }}</a></p>
                                            <p><a href="mailto:{{ $datos->email2 }}"
                                                    class="info-box_link">{{ $datos->email2 }}</a></p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon"><img src="{{ asset('assets/img/icon/location-dot.svg') }}"
                                                alt="img"></div>
                                        <div class="details">
                                            <p>{{ $datos->direccion }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-wrap" data-bg-src="{{ asset('assets/img/bg/copyright_bg_1.jpg') }}">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">Copyright 2025 <a href="home-travel.html">Magic Journeys</a>. Tous droits
                                réservés.</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-card"><span class="title">Nous acceptons</span> <img
                                    src="{{ asset('assets/img/shape/cards.png') }}" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="scroll-top">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
                </path>
            </svg>
        </div>
    </div>
    <div id="modales">
        @stack('modales')
    </div>
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/circle-progress.js') }}"></script>
    <script src="{{ asset('assets/js/matter.min.js') }}"></script>
    <script src="{{ asset('assets/js/matterjs-custom.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>