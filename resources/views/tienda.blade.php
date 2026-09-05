@extends('layout.es')
@section('titulo', 'Responsabilidad Social - Magic Tours')
@section('palabras')
@section('descripcion')
@section('contenido')
    @php
        $imagenes = [
            'IMG20250625162756-min.jpg',
            'IMG20250625162802-min.jpg',
            'IMG20250625162809-min.jpg',
            'IMG20250625162912-min.jpg',
            'IMG20250625162929-min.jpg',
            'IMG20250625162937-min.jpg',
            'IMG20250625162941-min.jpg',
            'IMG20250625163016-min.jpg',
            'IMG20250625163037-min.jpg',
            'IMG20250625163044-min.jpg',
            'IMG20250626091548_BURST000_COVER-min.jpg',
            'IMG20250626091608-min.jpg',
        ];

        $nombres = [
            'Faja andina multicolor',
            'Cinta tradicional tejida',
            'Chumpi ceremonial',
            'Manta cusqueño',
            'Manta cusqueño',
            'Manta cusqueño de colores',
            'Manta tejida con hilos naturales',
            'Poncho de uso textil tradicional',
            'Poncho de uso textil tradicional',
            'Manta de uso ceremonial',
            'Tela andina bicolor',
            'Chumpi ceremonial con motivos incaicos',
        ];

        $productos = [];

        foreach ($imagenes as $i => $img) {
            $productos[] = [
                'imagen' => $img,
                'nombre' => $nombres[$i],
                'precio' => rand(30, 120) . '.00',
                'rating' => number_format(rand(40, 50) / 10, 2), // entre 4.0 y 5.0
                'reviews' => rand(1, 20),
            ];
        }
    @endphp

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Responsabilidad social</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Responsabilidad social</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="py-5 bg-light">
        <div class="container">
            <p class="lead text-center mb-5">
                En nuestra empresa, dirigimos nuestros esfuerzos hacia la promoción del desarrollo integral de las
                comunidades rurales
                con las que trabajamos, las cuales cuentan con un valioso potencial cultural, tradicional y natural.
                Creemos firmemente en el poder del trabajo colaborativo y en la preservación del patrimonio local como
                motores de cambio positivo.
            </p>

            <div class="row mb-4">
                <div class="col-md-6 lead">
                    <p>
                        A través de alianzas significativas con estas comunidades, impulsamos proyectos de mejora en
                        infraestructuras turísticas
                        con un enfoque sostenible, que no solo fortalecen su atractivo como destinos, sino que también
                        elevan su calidad de vida.
                    </p>
                    <p>
                        Asimismo, respaldamos la producción y comercialización de textiles artesanales, honrando su
                        identidad ancestral
                        y fomentando oportunidades económicas inclusivas para sus habitantes.
                    </p>
                    <p>
                        Nuestra labor responde al compromiso de generar un impacto social duradero, promoviendo la equidad,
                        la sostenibilidad
                        cultural y el empoderamiento comunitario.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/img/tienda/IMG20250626091220-min.jpg') }}" 
                        style="width: 100%; height: 400px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;"
                        class="img-fluid rounded shadow"
                        alt="Responsabilidad Social">
                </div>
            </div>

            <h3 class="mb-3">Comunidades con las que trabajamos:</h3>
            <div class="accordion" id="comunidadesAccordion">
                @php
                    $comunidades = [
                        [
                            'nombre' => 'Comunidad de Paru Paru',
                            'descripcion' =>
                                'Es una comunidad campesina altoandina ubicada en el distrito de Pisac, en las alturas del Valle Sagrado de los incas, se encuentra a aproximadamente 3900 metros sobre el nivel del mar y es conocida por su increíble biodiversidad de papas nativas, sus prácticas agrícolas ancestrales y textiles tradicionales.',
                        ],
                        [
                            'nombre' => 'Comunidad de Mullakas-Misminay',
                            'descripcion' =>
                                'Es otra comunidad campesina altoandina ubicada en el distrito de Maras, en las alturas del Valle Sagrado de los incas, se encuentra a aproximadamente 3700 metros sobre el nivel del mar y es el lugar adecuado para participar en labores de siembra y cosecha del cultivo sagrado de los incas, el Maíz, utilizando técnicas y herramientas andinas.',
                        ],
                        [
                            'nombre' => 'Comunidad de Taucca',
                            'descripcion' =>
                                ' Es otra comunidad campesina altoandina ubicada en el distrito de Chinchero, junto a la laguna de Piuray, muy cerca al Valle Sagrado de los incas, se encuentra a aproximadamente 3750 metros sobre el nivel del mar, destacan por la crianza de cuyes y camélidos andinos como llamas y alpacas.',
                        ],
                        [
                            'nombre' => 'Comunidad de Patacancha',
                            'descripcion' =>
                                'Es otra comunidad campesina altoandina ubicada en el distrito de Ollantaytambo, en las alturas del Valle Sagrado de los incas, se encuentra a aproximadamente 3800 metros sobre el nivel del mar, aquí, la comunidad nos permite conocer de primera mano la tradición andina, pues su forma de vida diaria, costumbres y hasta su forma de vestir nos acerca a la forma de vida inca, al menos 500 años atrás. Es un pueblo reconocido culturalmente por sus icónicas obras en arte textil.',
                        ],
                    ];
                @endphp
                @foreach ($comunidades as $index => $comunidad)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $index }}">
                                {{ $comunidad['nombre'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}"
                            class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $index }}" data-bs-parent="#comunidadesAccordion">
                            <div class="accordion-body my-4 py-4">
                                {{ $comunidad['descripcion'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-4">
                Todas estas comunidades poseen un gran potencial de desarrollo turístico: caminata, ciclismo, pesca,
                astroturismo,
                observación de flora y fauna — muchas veces endémica — y más.
            </p>
        </div>
    </section>

    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row gy-40">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">
                        <div class="row gy-40">
                            @foreach ($productos as $producto)
                                <div class="col-xl-3 col-sm-6">
                                    <div class="th-product product-grid">
                                        <div class="product-img">
                                            <img src="{{ asset('assets/img/tienda/' . $producto['imagen']) }}"
                                                alt="{{ $producto['nombre'] }}"
                                                style="width: 100%; height: 240px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                            <span class="product-tag">Oferta</span>
                                            <div class="actions">
                                                <div class="whatsapp-icon">
                                                    <a href="https://api.whatsapp.com/send?phone=51953344808&text=Hola%20me%20interesa%20el%20producto%20{{ urlencode($producto['nombre']) }}"
                                                        target="_blank" class="icon-btn">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                                <div class="whatsapp-icon">
                                                    <a href="https://api.whatsapp.com/send?phone=519953354375&text=Hola%20me%20interesa%20el%20producto%20{{ urlencode($producto['nombre']) }}"
                                                        target="_blank" class="icon-btn">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3 class="product-title"><a
                                                    href="shop-details.html">{{ $producto['nombre'] }}</a></h3>
                                            <span class="price">S/ {{ $producto['precio'] }}</span>
                                            <div class="woocommerce-product-rating">
                                                <span class="count">({{ $producto['rating'] }} Reseña)</span>
                                                <div class="star-rating" role="img"
                                                    aria-label="Calificado {{ $producto['rating'] }} de 5">
                                                    <span>Calificado con <strong
                                                            class="rating">{{ $producto['rating'] }}</strong>
                                                        de 5 basado en <span
                                                            class="rating">{{ $producto['reviews'] }}</span> reseñas de
                                                        clientes</span>
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
        </div>
    </section>

@endsection
