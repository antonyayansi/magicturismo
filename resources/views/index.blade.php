@extends('layout.es')
@section('titulo', $datos->meta_title ?: 'MAGIC JOURNEYS PERU - Tours, Paquetes y Aventuras en Perú')
@section('palabras', $datos->meta_keywords ?: '')
@section('descripcion', $datos->meta_description ?: ($datos->desc_corto ?: ''))
@section('contenido')

    <div class="hero-2" id="hero">
        <div class="hero2-overlay" data-bg-src="{{ asset('assets/img/bg/line-pattern.png') }}"></div>
        <div class="swiper hero-slider-2" id="heroSlide2">
            <div class="swiper-wrapper">
                @foreach ($carrusels as $carru)
                    <div class="swiper-slide">
                        <div class="hero-inner">
                            @if ($carru->isVideo())
                                <video autoplay loop muted playsinline>
                                    <source src="{{ $carru->mediaUrl() }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ $carru->mediaUrl() }}" alt="{{ $carru->titulo }}" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
                            @endif
                            <div class="container">
                                <div class="hero-style2">
                                    <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">
                                        {{ $carru->titulo }}<span class="hero-text">{{ $carru->subtitulo }}</span>
                                    </h1>
                                    <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">{{ $carru->texto }}</p>
                                    @if ($carru->boton)
                                        <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s">
                                            <a href="{{ $carru->boton }}" class="th-btn white-btn th-icon">Explorar Más</a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pon los botones de color azul -->
            <div class="th-swiper-custom">
                <div class="swiper-pagination"></div>
                <div class="hero-icon">
                    <button data-slider-prev="#heroSlide2, #heroSlide3" class="hero-arrow slider-prev">
                        <img src="{{ asset('assets/img/icon/hero-arrow-left.svg') }}" alt="">
                    </button>
                    <button data-slider-next="#heroSlide2, #heroSlide3" class="hero-arrow slider-next">
                        <img src="{{ asset('assets/img/icon/hero-arrow-right.svg') }}" alt="">
                    </button>
                </div>
            </div>
        </div>
        <div class="swiper heroThumbs style2" id="heroSlide3">
            <div class="swiper-wrapper">
                @foreach ($tours as $paq)
                    <div class="swiper-slide">
                        <div class="hero-inner">
                            <div class="hero-card">
                                <div class="hero-img"><img src="{{ Storage::url($paq->imagen) }}"
                                        alt="{{ $paq->titulo }}" loading="lazy"></div>
                                <div class="hero-card_content">
                                    <h3 class="box-title">{{ $paq->titulo }}</h3>
                                    @if ($paq->precio)
                                        <h4 class="hero-card_price">
                                            <span class="currency">{{ $paq->precio }}</span>
                                            <span><i class="fa-light fa-clock"></i>{{ $paq->duracion }}</span>
                                        </h4>
                                    @endif
                                    <a href="{{ $paq->publicUrl() }}" class="th-btn style2">Reservar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="scroll-down">
            <a href="#paquetes" class="scroll-wrap">
                <span><img src="assets/img/icon/down-arrow.svg" alt="">
                </span>
                Scroll Down</a>
        </div>
    </div>

    <section class="category-area bg-top-center" data-bg-src="assets/img/bg/category_bg_1.png">
        <div class="container th-container">
            <div class="title-area text-center"><span class="sub-title">@contenido('home.categorias_subtitulo', 'Un lugar maravilloso para ti')</span>
                <h2 class="sec-title">@contenido('home.categorias_titulo', 'Nuestras Categorías')</h2>
            </div>

            <div class="swiper th-slider has-shadow categorySlider" id="categorySlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    @foreach ($categorias as $cate)
                        <div class="swiper-slide">
                            <div class="category-card single">
                                <div class="box-img global-img">
                                    <img src="{{ Storage::url($cate->img) }}" alt="{{ $cate->nombre }}" loading="lazy">
                                </div>
                                <h3 class="box-title">
                                    <a href="{{ route('categorias', $cate->slug) }}">{{ $cate->nombre }}</a>
                                </h3>
                                <a class="line-btn" href="{{ route('categorias', $cate->slug) }}">Ver Todos</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <div id="paquetes" class="booking-sec">
        <div class="container">
            <form action="#" method="POST" class="booking-form ajax-contact">
                <div class="input-wrap">
                    <div class="row align-items-center justify-content-between">
                        <div class="form-group col-md-6 col-lg-auto">
                            <div class="icon"><i class="fa-light fa-route"></i></div>
                            <div class="search-input"><label>Destino</label> <select name="subject" id="subject"
                                    class="form-select nice-select">
                                    <option value="Select Destination" selected="selected" disabled="disabled">Select
                                        Destination</option>
                                    @foreach (($destinos ?? collect(['CUSCO', 'LIMA', 'AREQUIPA', 'PUNO', 'PARACAS', 'ICA', 'NAZCA', 'AMAZONÍA'])) as $destino)
                                        <option value="{{ $destino }}">{{ $destino }}</option>
                                    @endforeach
                                </select></div>
                        </div>
                        <div class="form-group col-md-6 col-lg-auto">
                            <div class="icon"><i class="fa-regular fa-person-hiking"></i></div>
                            <div class="search-input"><label>Tipo</label> <select class="nice-select" name="Adventure"
                                    id="Adventure">
                                    <option value="Adventure" selected="selected" disabled="disabled">Adventure
                                    </option>
                                    <option value="tour">Tour</option>
                                    <option value="paquete">Paquetes</option>
                                    <option value="caminata">Caminatas</option>
                                    <option value="diferente">Diferente</option>
                                </select></div>
                        </div>
                        <div class="form-group col-md-6 col-lg-auto">
                            <div class="icon"><i class="fa-light fa-clock"></i></div>
                            <div class="search-input"><label>Duración</label> <select class="form-select nice-select"
                                    name="Duration" id="Duration">
                                    <option value="Normal" selected="selected" disabled="disabled">Duración</option>
                                    <option value="1">1 día</option>
                                    <option value="2">2 días</option>
                                    <option value="3">3 días</option>
                                    <option value="4">4 días</option>
                                    <option value="5">5 días</option>
                                    <option value="6">6 días</option>
                                    <option value="7">7 días</option>
                                </select></div>
                        </div>
                        <div class="form-btn col-md-12 col-lg-auto"><button onclick="searchTours()" class="th-btn"><img
                                    src="assets/img/icon/search.svg" alt="">Buscar</button></div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </div>
            </form>
        </div>
    </div>

    <div class="destination-area position-relative overflow-hidden">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title">@contenido('home.paquetes_subtitulo', 'Nuestros')</span>
                <h2 class="sec-title">@contenido('home.paquetes_titulo', 'Paquetes')</h2>
            </div>
            <div class="swiper th-slider destination-slider slider-drag-wrap" id="aboutSlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                <div class="swiper-wrapper">
                    @foreach ($todos as $paq)
                        <div class="swiper-slide">
                            <div class="destination-box gsap-cursor">
                                <div class="destination-img">
                                    <img src="{{ Storage::url($paq->imagen) }}" alt="{{ $paq->titulo }}" loading="lazy">
                                    <div class="destination-content">
                                        <div class="media-left text-center">
                                            <h4 class="box-title"><a href="{{ $paq->publicUrl() }}">{{ $paq->titulo }}</a></h4>
                                            <span class="destination-subtitle">{{ $paq->tipo }}</span>
                                            <div class="mt-2"><a href="{{ $paq->publicUrl() }}"
                                                    class="th-btn style2 th-icon">Detalle</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="img-box1">
                        <div class="img1"><img src="{{ \App\Models\Contenido::imagenUrl('home.about_img1', asset('assets/img/normal/about_1_1.jpg')) }}" alt="About" loading="lazy">
                        </div>
                        <div class="img2"><img src="{{ \App\Models\Contenido::imagenUrl('home.about_img2', asset('assets/img/normal/about_1_2.jpg')) }}" alt="About" loading="lazy">
                        </div>
                        <div class="img3"><img src="{{ \App\Models\Contenido::imagenUrl('home.about_img3', asset('assets/img/normal/about_1_3.jpg')) }}" alt="About" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xl-4 ms-xl-2">
                        <div class="title-area mb-20 pe-xl-5 me-xl-5"><span class="sub-title style1">@contenido('home.about_subtitulo', 'Explora el Mundo con Nosotros')</span>
                            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">@contenido('home.about_titulo', 'Diseñamos tu aventura perfecta, a tu ritmo y medida.')</h2>
                        </div>
                        <div class="about-item-wrap">
                            <div class="about-item">
                                <div class="about-item_img"><img src="assets/img/icon/map3.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">@contenido('home.about_item1_titulo', 'Viaje Exclusivo')</h5>
                                    <p class="about-item_text">@contenido('home.about_item1_texto', 'Cada viaje es una historia irrepetible. Haz que la tuya comience aquí.')</p>
                                </div>
                            </div>
                            <div class="about-item">
                                <div class="about-item_img"><img src="assets/img/icon/guide.svg" alt="">
                                </div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">@contenido('home.about_item2_titulo', 'Guía Profesional')</h5>
                                    <p class="about-item_text">@contenido('home.about_item2_texto', 'Nuestro equipo de guías locales hará que vivas cada destino como un verdadero explorador.')</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-35"><a href="{{ route('tours') }}" class="th-btn style3 th-icon">Ver tours</a></div>
                    </div>
                </div>
            </div>
            <div class="shape-mockup shape1 d-none d-xl-block" data-top="12%" data-left="-16%"><img
                    src="{{ asset('assets/img/shape/shape_1.png') }}" alt="shape"></div>
            <div class="shape-mockup shape2 d-none d-xl-block" data-top="20%" data-left="-16%"><img
                    src="{{ asset('assets/img/shape/shape_2.png') }}" alt="shape"></div>
            <div class="shape-mockup shape3 d-none d-xl-block" data-top="14%" data-left="-10%"><img
                    src="{{ asset('assets/img/shape/shape_3.png') }}" alt="shape"></div>
            <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="0%" data-right="-11%"><img
                    src="{{ asset('assets/img/normal/about-slide-img.png') }}" alt="shape"></div>
            <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="50%" data-right="-20%"><i
                    class="fa-sharp fa-solid fa-star"></i><span>4.9k</span></div>
            <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="25%" data-right="5%"><img
                    src="{{ asset('assets/img/icon/emoji.png') }}" alt=""></div>
        </div>
    </div>

    <section class="tour-area position-relative bg-top-center overflow-hidden space" id="service-sec"
        data-bg-src="{{ asset('assets/img/bg/tour_bg_1.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="title-area text-center"><span class="sub-title">@contenido('home.diferente_subtitulo', 'Conoce')</span>
                        <h2 class="sec-title">@contenido('home.diferente_titulo', 'Algo diferente')</h2>
                        <p class="sec-text">@contenido('home.diferente_texto', 'Cusco es mucho más que Machu Picchu y las postales clásicas. Es una tierra llena de rincones sorprendentes, pueblos vivos, sabores únicos y tradiciones que siguen latiendo en el corazón de los Andes. Aquí, cada calle es una historia, cada mirada es un encuentro, y cada paso te lleva a lo nuevo por descubrir.')</p>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($diferentes as $dife)
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor tour-box-gallery">
                                    <div class="tour-box_img global-img tour-gallery-container">
                                        <img src="{{ Storage::url($dife->imagen) }}" alt="{{ $dife->titulo }}" class="main-image" loading="lazy">
                                        @if($dife->galeria && $dife->galeria->count() > 0)
                                            <div class="gallery-grid-wrapper">
                                                @foreach($dife->galeria->take(3) as $index => $img)
                                                    <div class="gallery-grid-item gallery-item-{{ $index + 1 }}">
                                                        <img src="{{ Storage::url($img->img) }}" 
                                                             alt="gallery image {{ $index + 1 }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tour-content">
                                        <h3 class="box-title">
                                            <a href="{{ $dife->publicUrl() }}">{{ $dife->titulo }}</a>
                                        </h3>
                                        <div class="tour-action"><span><i
                                                    class="fa-light fa-clock"></i>{{ $dife->duracion }}</span> <a
                                                href="{{ $dife->publicUrl() }}"
                                                class="th-btn style4 th-icon">Ver más</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            
            <style>
                .tour-gallery-container {
                    position: relative;
                    overflow: hidden;
                    height: 300px;
                }

                .tour-gallery-container .main-image {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: opacity 0.5s ease, transform 0.5s ease;
                }

                /* Grid de galería - oculto por defecto */
                .gallery-grid-wrapper {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    gap: 0;
                    opacity: 0;
                    transition: opacity 0.5s ease;
                }

                .gallery-grid-item {
                    flex: 1;
                    overflow: hidden;
                    transform: scaleX(0);
                    transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                }

                .gallery-grid-item img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transform: scale(1.2);
                    transition: transform 0.6s ease;
                }

                /* Delays para cada columna */
                .gallery-item-1 {
                    transition-delay: 0s;
                }

                .gallery-item-2 {
                    transition-delay: 0.1s;
                }

                .gallery-item-3 {
                    transition-delay: 0.2s;
                }

                /* Efecto hover */
                .tour-box-gallery:hover .main-image {
                    opacity: 0;
                    transform: scale(1.1);
                }

                .tour-box-gallery:hover .gallery-grid-wrapper {
                    opacity: 1;
                }

                .tour-box-gallery:hover .gallery-grid-item {
                    transform: scaleX(1);
                }

                .tour-box-gallery:hover .gallery-grid-item img {
                    transform: scale(1);
                }

                /* Hover individual en cada imagen */
                .gallery-grid-item:hover img {
                    transform: scale(1.1) !important;
                }

                /* Ajustes responsive */
                @media (max-width: 1199px) {
                    .tour-gallery-container {
                        height: 280px;
                    }
                }

                @media (max-width: 991px) {
                    .tour-gallery-container {
                        height: 260px;
                    }
                }

                @media (max-width: 767px) {
                    .tour-gallery-container {
                        height: 240px;
                    }
                }

                @media (max-width: 575px) {
                    .tour-gallery-container {
                        height: 280px;
                    }
                    
                    /* En móvil, mostrar las imágenes apiladas verticalmente */
                    .gallery-grid-wrapper {
                        flex-direction: column;
                    }
                }
            </style>
        </div>
    </section>
    <div class="gallery-area mt-5">
        <div class="container th-container">
            <div class="title-area text-center"><span class="sub-title">@contenido('home.galeria_subtitulo', 'Nuestra Galería')</span>
                <h2 class="sec-title">@contenido('home.galeria_titulo', 'Imágenes')</h2>
            </div>
            <div class="shape-mockup d-none d-xl-block" data-top="-25%" data-left="0%"><img
                    src="{{ asset('assets/img/shape/line.png') }}" alt="shape"></div>
            <div class="shape-mockup movingX d-none d-xl-block" data-top="30%" data-left="-3%"><img class="gmovingX"
                    src="{{ asset('assets/img/shape/shape_4.png') }}" alt="shape"></div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider tourSlider2 slider-drag-wrap has-shadow" id="tourSlider2"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"480":{"slidesPerView":2},"576":{"slidesPerView":"2"},"1199":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($tours as $tour)
                        <div class="swiper-slide">
                            <div class="tour-card th-ani gsap-cursor">
                                <div class="tour-card_img global-img"><img src="{{ Storage::url($tour->imagen) }}"
                                        alt="{{ $tour->titulo }}" loading="lazy"></div>
                                <div class="tour-content">
                                    <h3 class="box-title"><a href="{{ route('toursdetalle', $tour->slug) }}">{{ $tour->titulo }}</a></h3>
                                    <div class="tour-rating">
                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span
                                                style="width:100%">Rated <strong class="rating">5.00</strong> out of 5
                                                based on <span class="rating">4.8</span>(4.8 Rating)</span></div><a
                                            href="{{ route('toursdetalle', $tour->slug) }}" class="woocommerce-review-link">(<span
                                                class="count">4.8</span> Rating)</a>
                                    </div>
                                    <div class="tour-action"><span><i class="fa-light fa-clock"></i>{{ $tour->duracion }}</span> <a
                                            href="{{ route('toursdetalle', $tour->slug) }}" class="th-btn style4">Más detalles</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="testi-area overflow-hidden space" id="testi-sec">
        <div class="container-fluid p-0">
            <div class="title-area mb-20 text-center"><span class="sub-title">@contenido('home.testimonios_subtitulo', 'Testimonios')</span>
                <h2 class="sec-title">@contenido('home.testimonios_titulo', 'Nuestros clientes opinan')</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"2","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2","centeredSlides":"true"},"1400":{"slidesPerView":"3","centeredSlides":"true"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($testimonios as $tes)
                            <div class="swiper-slide">
                                <div class="testi-card">
                                    <div class="testi-card_wrapper">
                                        <div class="testi-card_profile">
                                            <div class="media-body">
                                                <h3 class="box-title">{{ $tes->nombres }}</h3><span
                                                    class="testi-card_desig">{{ $tes->cargo }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <p class="testi-card_text">“{{ $tes->texto }}”</p>
                                    <div class="testi-card-quote"><img src="{{ asset('assets/img/icon/testi-quote.svg') }}"
                                            alt="img">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
        <div class="shape-mockup d-none d-xl-block" data-bottom="-2%" data-right="0%"><img src="assets/img/shape/line2.png"
                alt="shape"></div>
        <div class="shape-mockup movingX d-none d-xl-block" data-top="30%" data-left="5%"><img
                src="assets/img/shape/shape_7.png" alt="shape"></div>
    </section>

    <section class="bg-smoke overflow-hidden space" id="blog-sec">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0"><span class="sub-title">@contenido('home.blog_subtitulo', 'Viajes')</span>
                            <h2 class="sec-title">@contenido('home.blog_titulo', 'Creando viajes sostenibles')</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="blogSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($diferentes as $diferente)
                            <div class="swiper-slide">
                                <div class="blog-box th-ani">
                                    <div class="blog-img global-img"><img
                                            src="{{ Storage::url($diferente->imagen) }}" alt="{{ $diferente->titulo }}" loading="lazy">
                                    </div>
                                    <div class="blog-box_content">
                                        <h3 class="box-title"><a href="{{ $diferente->publicUrl() }}">{{ $diferente->titulo }}</a></h3><a href="{{ $diferente->publicUrl() }}" class="th-btn style4 th-icon">
                                            Saber más</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="20%" data-left="-17%"><img
                    src="assets/img/shape/shape_1.png" alt="shape"></div>
            <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="5%" data-left="-17%"><img
                    src="assets/img/shape/shape_2.png" alt="shape"></div>
            <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="12%" data-left="-10%"><img
                    src="assets/img/shape/shape_3.png" alt="shape"></div>
        </div>
    </section>
    <script>
        const searchTours = () => {
            
            const subject = document.getElementById('subject').value;
            const adventure = document.getElementById('Adventure').value;
            const duration = document.getElementById('Duration').value;

            if(!subject || subject == 'Select Destination'){
                alert('Por favor selecciona un destino');
                return;
            }
            if(!adventure || adventure == 'Adventure'){
                alert('Por favor selecciona un tipo de aventura');
                return;
            }
            if(!duration || duration == 'Normal'){
                alert('Por favor selecciona una duración');
                return;
            }

            const params = `destino=${encodeURIComponent(subject)}&tipo=${encodeURIComponent(adventure)}&duracion=${encodeURIComponent(duration)}`;
            if(adventure == 'tour'){
                window.location.href = `/tours?${params}`;
            }else if(adventure == 'paquete'){
                window.location.href = `/paquetes?${params}`;
            }else if(adventure == 'caminata'){
                window.location.href = `/caminatas?${params}`;
            }else{
                window.location.href = `/diferente?${params}`;
            }
                
        }
    </script>
@endsection