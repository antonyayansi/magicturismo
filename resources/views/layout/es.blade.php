<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('titulo', $datos->meta_title ?? 'Magic Journeys Peru')</title>
    <meta name="author" content="Magic Journeys Peru">
    <meta name="description" content="@yield('descripcion', $datos->meta_description ?? ($datos->desc_corto ?? ''))">
    <meta name="keywords" content="@yield('palabras', $datos->meta_keywords ?? '')">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('titulo')) ?: ($datos->meta_title ?? 'Magic Journeys Peru'))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('descripcion')) ?: ($datos->meta_description ?? ''))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', \App\Services\SiteSettings::logoUrl())">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $datos->nombre ?? 'Magic Journeys Peru' }}">
    <link rel="icon" href="{{ \App\Services\SiteSettings::faviconUrl() }}">
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
    @php
        $logoUrl = \App\Services\SiteSettings::logoUrl();
        $urlFrances = $datos->url_frances ?: 'https://voyagesmagiquesperou.com/';
        $faqUrl = $datos->faq_url ?: '#';
        $soporteUrl = $datos->soporte_url ?: '#';
        $navTours = \App\Services\SiteSettings::navTours();
        $navPaquetes = \App\Services\SiteSettings::navPaquetes();
        $hasCmsHeader = isset($menuHeader) && $menuHeader instanceof \Illuminate\Support\Collection && $menuHeader->isNotEmpty();
        $hasCmsFooter = isset($menuFooter) && $menuFooter instanceof \Illuminate\Support\Collection && $menuFooter->isNotEmpty();
        $footerAbout = $datos->footer_texto ?: \App\Models\Contenido::texto('footer.about', 'Diseñamos experiencias auténticas en Perú: tours, caminatas y paquetes a tu medida.');
        $copyright = $datos->copyright ?: ('Copyright '.date('Y').' Magic Journeys. All Rights Reserved.');
    @endphp
    <script>
        function cambiarIdioma(valor) {
            if (valor === 'fr') {
                window.location.href = @json($urlFrances);
            } else if (valor === 'es') {
                window.location.href = @json(url('/'));
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
            <div class="preloader-inner"><img style="width: 220px" src="{{ $logoUrl }}"
                    alt="Magic Journeys Peru"></div>
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
                        <img src="{{ $logoUrl }}" width="150px" alt="Magic Journeys Peru"></a>
                </div>
                <div class="th-mobile-menu">
                    <ul>
                        @if ($hasCmsHeader)
                            @foreach ($menuHeader as $item)
                                @php
                                    $href = $item->href();
                                    $isTours = ($item->ruta === 'tours') || str_contains($href, '/tours');
                                    $isPaquetes = ($item->ruta === 'paquetes') || str_contains($href, '/paquetes');
                                    $hasChildren = $item->children->isNotEmpty() || $isTours || $isPaquetes;
                                @endphp
                                <li class="{{ $hasChildren ? 'menu-item-has-children' : '' }}">
                                    <a href="{{ $href }}" target="{{ $item->target }}">{{ $item->label }}</a>
                                    @if ($hasChildren)
                                        <ul class="sub-menu">
                                            @forelse ($item->children as $child)
                                                <li><a href="{{ $child->href() }}" target="{{ $child->target }}">{{ $child->label }}</a></li>
                                            @empty
                                                @if ($isTours)
                                                    @foreach ($navTours as $tour)
                                                        <li><a href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a></li>
                                                    @endforeach
                                                @elseif ($isPaquetes)
                                                    @foreach ($navPaquetes as $paq)
                                                        <li><a href="{{ route('paquetesdetalle', ['slug' => $paq->slug]) }}">{{ $paq->titulo }}</a></li>
                                                    @endforeach
                                                @endif
                                            @endforelse
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('tours') }}">Tours</a>
                                <ul class="sub-menu">
                                    @foreach ($navTours as $tour)
                                        <li><a href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('caminatas') }}">Caminatas</a></li>
                            <li class="menu-item-has-children"><a href="{{ route('paquetes') }}">Paquetes</a>
                                <ul class="sub-menu">
                                    @foreach ($navPaquetes as $paq)
                                        <li><a href="{{ route('paquetesdetalle', ['slug' => $paq->slug]) }}">{{ $paq->titulo }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('responsabilidad') }}">Responsabilidad social</a></li>
                            <li><a href="{{ route('contacto') }}">Contactos - Conocenos</a></li>
                        @endif
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
                                        <option selected="">Preferencias</option>
                                        <option value="normal">
                                            Normal
                                        </option>
                                        <option value="blanconegro">
                                            Blanco y Negro
                                        </option>
                                    </select>
                                </div>
                                <div class="currency-menu">
                                    <select class="form-select nice-select" onchange="cambiarIdioma(this.value)">
                                        <option selected="">Idioma</option>
                                        <option value="fr">
                                            FR
                                        </option>
                                    </select>
                                </div>
                                <div class="header-links">
                                    <ul>
                                        <li class="d-none d-md-inline-block"><a href="{{ $faqUrl }}">Preguntas frecuentes</a>
                                        </li>
                                        <li class="d-none d-md-inline-block"><a href="{{ $soporteUrl }}">Soporte</a></li>
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
                                        <img src="{{ $logoUrl }}" alt="Magic Journeys Peru" width="100px">
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto me-xl-auto " style="margin-left: 120px;">
                                <nav class="main-menu d-none d-xl-inline-block">
                                    <ul>
                                        @if ($hasCmsHeader)
                                            @foreach ($menuHeader as $item)
                                                @php
                                                    $href = $item->href();
                                                    $isTours = ($item->ruta === 'tours') || str_contains($href, '/tours');
                                                    $isPaquetes = ($item->ruta === 'paquetes') || str_contains($href, '/paquetes');
                                                    $hasChildren = $item->children->isNotEmpty() || $isTours || $isPaquetes;
                                                @endphp
                                                <li class="{{ $hasChildren ? 'menu-item-has-children' : '' }}">
                                                    <a href="{{ $href }}" target="{{ $item->target }}">{{ $item->label }}</a>
                                                    @if ($hasChildren)
                                                        <ul class="sub-menu">
                                                            @forelse ($item->children as $child)
                                                                <li><a href="{{ $child->href() }}" target="{{ $child->target }}">{{ $child->label }}</a></li>
                                                            @empty
                                                                @if ($isTours)
                                                                    @foreach ($navTours as $tour)
                                                                        <li><a href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a></li>
                                                                    @endforeach
                                                                @elseif ($isPaquetes)
                                                                    @foreach ($navPaquetes as $paq)
                                                                        <li><a href="{{ route('paquetesdetalle', ['slug' => $paq->slug]) }}">{{ $paq->titulo }}</a></li>
                                                                    @endforeach
                                                                @endif
                                                            @endforelse
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @else
                                            <li><a href="{{ route('home') }}"
                                                    class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                                            <li class="menu-item-has-children"><a href="{{ route('tours') }}">Tours</a>
                                                <ul class="sub-menu">
                                                    @foreach ($navTours as $tour)
                                                        <li><a
                                                                href="{{ route('toursdetalle', ['slug' => $tour->slug]) }}">{{ $tour->titulo }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('caminatas') }}">Caminatas</a></li>
                                            <li class="menu-item-has-children"><a href="{{ route('paquetes') }}">Paquetes</a>
                                                <ul class="sub-menu">
                                                    @foreach ($navPaquetes as $paq)
                                                        <li><a
                                                                href="{{ route('paquetesdetalle', ['slug' => $paq->slug]) }}">{{ $paq->titulo }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('responsabilidad') }}"
                                                    class="{{ request()->routeIs('responsabilidad') ? 'active' : '' }}">
                                                    Responsabilidad Social</a></li>
                                            <li><a href="{{ route('contacto') }}"
                                                    class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contactos -
                                                    Conocenos</a></li>
                                        @endif
                                    </ul>
                                </nav><button type="button" class="th-menu-toggle d-block d-xl-none">
                                    <i class="far fa-bars"></i></button>
                            </div>
                            <div class="col-auto d-none d-xl-block">
                                @if (Auth::user() == null)
                                    <div class="header-button">
                                        <a href="/login" class="th-btn style3 th-icon"> Login</a>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <button class="th-btn style4 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            {{ Auth::user()->displayName() }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if(Auth::user()->isAdmin() || Auth::user()->isAgente())
                                                <li>
                                                    <a class="dropdown-item" href="/admin">Panel
                                                        Admin</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="#">Mis compras</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Mis reservas</a></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
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
                                    <h2 class="newsletter-title text-capitalize mb-0">@contenido('footer.newsletter_titulo', 'Manténgase actualizado con el último boletín informativo')
                                    </h2>
                                </div>
                                <div class="col-lg-7">
                                    <form class="newsletter-form"><input class="form-control" type="email"
                                            placeholder="Ingrese su correo electrónico" required=""> <button type="submit"
                                            class="th-btn style3">Suscribirse <img
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
                                    <div class="about-logo"><a href="{{ route('home') }}"><img
                                                src="{{ $logoUrl }}" alt="Magic Journeys Peru"></a>
                                    </div>
                                    <p class="about-text">{{ $footerAbout }}</p>
                                    <div class="th-social">
                                        @if($datos->facebook)<a href="{{ $datos->facebook }}" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>@endif
                                        @if($datos->twitter)<a href="{{ $datos->twitter }}" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>@endif
                                        @if($datos->linkedin)<a href="{{ $datos->linkedin }}" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>@endif
                                        @if($datos->whatsapp)<a href="{{ $datos->whatsapp }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>@endif
                                        @if($datos->instagram)<a href="{{ $datos->instagram }}" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>@endif
                                        @if($datos->youtube)<a href="{{ $datos->youtube }}" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">Accesos directos</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        @if ($hasCmsFooter)
                                            @foreach ($menuFooter as $item)
                                                <li><a href="{{ $item->href() }}" target="{{ $item->target }}">{{ $item->label }}</a></li>
                                            @endforeach
                                        @else
                                            <li><a href="/">Home</a></li>
                                            <li><a href="/contacto">Conocenos</a></li>
                                            <li><a href="/tours">Nuestros Tours</a></li>
                                            <li><a href="/paquetes">Paquetes</a></li>
                                            <li><a href="/caminatas">Caminatas</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget footer-widget">
                                <h3 class="widget_title">Address</h3>
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
                            <p class="copyright-text">{!! $copyright !!}</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-card"><span class="title">Aceptamos</span> <img
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
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => $datos->nombre ?? 'Magic Journeys Peru',
            'url' => url('/'),
            'logo' => $logoUrl,
            'description' => $datos->meta_description ?? ($datos->desc_corto ?? ''),
            'telephone' => $datos->telefono ?? null,
            'email' => $datos->email ?? null,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $datos->direccion ?? null,
            ],
            'sameAs' => array_values(array_filter([
                $datos->facebook ?? null,
                $datos->instagram ?? null,
                $datos->youtube ?? null,
                $datos->linkedin ?? null,
                $datos->twitter ?? null,
            ])),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</body>

</html>
