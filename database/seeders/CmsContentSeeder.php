<?php

namespace Database\Seeders;

use App\Models\Contenido;
use App\Models\MenuItem;
use App\Models\Pagina;
use App\Models\datos_empresa;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        $contenidos = [
            ['clave' => 'home.categorias_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo categorías', 'texto' => 'Un lugar maravilloso para ti'],
            ['clave' => 'home.categorias_titulo', 'grupo' => 'inicio', 'titulo' => 'Título categorías', 'texto' => 'Nuestras Categorías'],
            ['clave' => 'home.about_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo nosotros', 'texto' => 'Explora el Mundo con Nosotros'],
            ['clave' => 'home.about_titulo', 'grupo' => 'inicio', 'titulo' => 'Título nosotros', 'texto' => 'Diseñamos tu aventura perfecta, a tu ritmo y medida.'],
            ['clave' => 'home.about_item1_titulo', 'grupo' => 'inicio', 'titulo' => 'Bloque 1 título', 'texto' => 'Viaje Exclusivo'],
            ['clave' => 'home.about_item1_texto', 'grupo' => 'inicio', 'titulo' => 'Bloque 1 texto', 'texto' => 'Cada viaje es una historia irrepetible. Haz que la tuya comience aquí.'],
            ['clave' => 'home.about_item2_titulo', 'grupo' => 'inicio', 'titulo' => 'Bloque 2 título', 'texto' => 'Guía Profesional'],
            ['clave' => 'home.about_item2_texto', 'grupo' => 'inicio', 'titulo' => 'Bloque 2 texto', 'texto' => 'Nuestro equipo de guías locales hará que vivas cada destino como un verdadero explorador.'],
            ['clave' => 'home.diferente_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo algo diferente', 'texto' => 'Conoce'],
            ['clave' => 'home.diferente_titulo', 'grupo' => 'inicio', 'titulo' => 'Título algo diferente', 'texto' => 'Algo diferente'],
            ['clave' => 'home.diferente_texto', 'grupo' => 'inicio', 'titulo' => 'Texto algo diferente', 'texto' => 'Cusco es mucho más que Machu Picchu y las postales clásicas. Es una tierra llena de rincones sorprendentes, pueblos vivos, sabores únicos y tradiciones que siguen latiendo en el corazón de los Andes. Aquí, cada calle es una historia, cada mirada es un encuentro, y cada paso te lleva a lo nuevo por descubrir.'],
            ['clave' => 'detalle.label_incluye', 'grupo' => 'detalle', 'titulo' => 'Etiqueta incluye', 'texto' => 'Incluye'],
            ['clave' => 'detalle.label_no_incluye', 'grupo' => 'detalle', 'titulo' => 'Etiqueta no incluye', 'texto' => 'No Incluye'],
            ['clave' => 'detalle.label_plan', 'grupo' => 'detalle', 'titulo' => 'Etiqueta plan', 'texto' => 'Tour Plan'],
            ['clave' => 'detalle.label_galeria', 'grupo' => 'detalle', 'titulo' => 'Etiqueta galería', 'texto' => 'Galería'],
            ['clave' => 'footer.about', 'grupo' => 'footer', 'titulo' => 'Texto del pie', 'texto' => 'Diseñamos experiencias auténticas en Perú: tours, caminatas y paquetes a tu medida.'],
            ['clave' => 'footer.newsletter_titulo', 'grupo' => 'footer', 'titulo' => 'Título newsletter', 'texto' => 'Manténgase actualizado con el último boletín informativo'],
            ['clave' => 'contacto.subtitulo', 'grupo' => 'contacto', 'titulo' => 'Subtítulo contacto', 'texto' => 'Bienvenido a Magic Journeys'],
            ['clave' => 'contacto.titulo', 'grupo' => 'contacto', 'titulo' => 'Título contacto', 'texto' => 'Vive, explora y descubre el mundo con nosotros.'],
            ['clave' => 'contacto.parrafo1', 'grupo' => 'contacto', 'titulo' => 'Párrafo 1', 'texto' => 'Somos una agencia de viajes reconocida a nivel mundial, especializada en ofrecer experiencias inolvidables a nuestros clientes.'],
            ['clave' => 'contacto.parrafo2', 'grupo' => 'contacto', 'titulo' => 'Párrafo 2', 'texto' => 'Existen muchas formas de viajar, pero la mayoría de experiencias comunes han sido afectadas por servicios poco personalizados. En Magic Journeys nos enfocamos en brindarte aventuras auténticas, cuidadosamente diseñadas para que cada momento cuente.'],
            ['clave' => 'home.paquetes_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo paquetes', 'texto' => 'Nuestros'],
            ['clave' => 'home.paquetes_titulo', 'grupo' => 'inicio', 'titulo' => 'Título paquetes', 'texto' => 'Paquetes'],
            ['clave' => 'home.galeria_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo galería', 'texto' => 'Nuestra Galería'],
            ['clave' => 'home.galeria_titulo', 'grupo' => 'inicio', 'titulo' => 'Título galería', 'texto' => 'Imágenes'],
            ['clave' => 'home.testimonios_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo testimonios', 'texto' => 'Testimonios'],
            ['clave' => 'home.testimonios_titulo', 'grupo' => 'inicio', 'titulo' => 'Título testimonios', 'texto' => 'Nuestros clientes opinan'],
            ['clave' => 'home.blog_subtitulo', 'grupo' => 'inicio', 'titulo' => 'Subtítulo viajes', 'texto' => 'Viajes'],
            ['clave' => 'home.blog_titulo', 'grupo' => 'inicio', 'titulo' => 'Título viajes', 'texto' => 'Creando viajes sostenibles'],
            ['clave' => 'listados.tours_titulo', 'grupo' => 'listados', 'titulo' => 'Título listado tours', 'texto' => 'Nuestros Tours'],
            ['clave' => 'listados.tours_meta_title', 'grupo' => 'listados', 'titulo' => 'SEO título tours', 'texto' => 'Tours | Magic Journeys Peru'],
            ['clave' => 'listados.tours_meta_description', 'grupo' => 'listados', 'titulo' => 'SEO descripción tours', 'texto' => 'Descubre nuestros tours en Cusco y el Perú.'],
            ['clave' => 'listados.paquetes_titulo', 'grupo' => 'listados', 'titulo' => 'Título listado paquetes', 'texto' => 'Nuestros Paquetes'],
            ['clave' => 'listados.paquetes_meta_title', 'grupo' => 'listados', 'titulo' => 'SEO título paquetes', 'texto' => 'Paquetes | Magic Journeys Peru'],
            ['clave' => 'listados.paquetes_meta_description', 'grupo' => 'listados', 'titulo' => 'SEO descripción paquetes', 'texto' => 'Paquetes de viaje en Cusco y el Perú.'],
            ['clave' => 'listados.caminatas_titulo', 'grupo' => 'listados', 'titulo' => 'Título listado caminatas', 'texto' => 'Nuestras Caminatas'],
            ['clave' => 'listados.caminatas_meta_title', 'grupo' => 'listados', 'titulo' => 'SEO título caminatas', 'texto' => 'Caminatas | Magic Journeys Peru'],
            ['clave' => 'listados.caminatas_meta_description', 'grupo' => 'listados', 'titulo' => 'SEO descripción caminatas', 'texto' => 'Caminatas y trekking en Cusco y el Perú.'],
            ['clave' => 'listados.diferente_titulo', 'grupo' => 'listados', 'titulo' => 'Título listado diferente', 'texto' => 'Algo diferente'],
            ['clave' => 'listados.diferente_meta_title', 'grupo' => 'listados', 'titulo' => 'SEO título diferente', 'texto' => 'Algo diferente | Magic Journeys Peru'],
            ['clave' => 'listados.diferente_meta_description', 'grupo' => 'listados', 'titulo' => 'SEO descripción diferente', 'texto' => 'Experiencias distintas en Cusco y el Perú.'],
            ['clave' => 'tienda.titulo', 'grupo' => 'tienda', 'titulo' => 'Título responsabilidad', 'texto' => 'Responsabilidad social'],
            ['clave' => 'tienda.meta_title', 'grupo' => 'tienda', 'titulo' => 'SEO título responsabilidad', 'texto' => 'Responsabilidad Social | Magic Journeys Peru'],
            ['clave' => 'tienda.meta_description', 'grupo' => 'tienda', 'titulo' => 'SEO descripción responsabilidad', 'texto' => 'Trabajamos con comunidades rurales del Perú.'],
            ['clave' => 'tienda.intro', 'grupo' => 'tienda', 'titulo' => 'Intro responsabilidad', 'texto' => 'En nuestra empresa, dirigimos nuestros esfuerzos hacia la promoción del desarrollo integral de las comunidades rurales con las que trabajamos, las cuales cuentan con un valioso potencial cultural, tradicional y natural. Creemos firmemente en el poder del trabajo colaborativo y en la preservación del patrimonio local como motores de cambio positivo.'],
        ];

        foreach ($contenidos as $index => $item) {
            Contenido::query()->firstOrCreate(
                ['clave' => $item['clave']],
                $item + ['orden' => $index + 1, 'estado' => 'activo']
            );
        }

        Pagina::query()->firstOrCreate(
            ['slug' => 'contacto'],
            [
                'titulo' => 'Nosotros',
                'extracto' => 'Conoce Magic Journeys Peru',
                'contenido' => null,
                'meta_title' => 'Sobre nosotros | Magic Journeys Peru',
                'meta_description' => 'Conoce a Magic Journeys Peru, agencia de tours, caminatas y paquetes en Cusco y el Perú.',
                'estado' => 'activo',
            ]
        );

        Pagina::query()->firstOrCreate(
            ['slug' => 'responsabilidad'],
            [
                'titulo' => 'Responsabilidad social',
                'extracto' => 'Trabajamos con comunidades rurales del Perú.',
                'contenido' => null,
                'meta_title' => 'Responsabilidad Social | Magic Journeys Peru',
                'meta_description' => 'Impulsamos el desarrollo de comunidades rurales a través del turismo sostenible.',
                'estado' => 'activo',
            ]
        );

        if (MenuItem::query()->count() === 0) {
            $items = [
                ['ubicacion' => 'header', 'label' => 'Home', 'ruta' => 'home', 'orden' => 1],
                ['ubicacion' => 'header', 'label' => 'Tours', 'ruta' => 'tours', 'orden' => 2],
                ['ubicacion' => 'header', 'label' => 'Caminatas', 'ruta' => 'caminatas', 'orden' => 3],
                ['ubicacion' => 'header', 'label' => 'Paquetes', 'ruta' => 'paquetes', 'orden' => 4],
                ['ubicacion' => 'header', 'label' => 'Responsabilidad Social', 'ruta' => 'responsabilidad', 'orden' => 5],
                ['ubicacion' => 'header', 'label' => 'Contactos - Conócenos', 'ruta' => 'contacto', 'orden' => 6],
                ['ubicacion' => 'footer', 'label' => 'Home', 'ruta' => 'home', 'orden' => 1],
                ['ubicacion' => 'footer', 'label' => 'Conócenos', 'ruta' => 'contacto', 'orden' => 2],
                ['ubicacion' => 'footer', 'label' => 'Nuestros Tours', 'ruta' => 'tours', 'orden' => 3],
                ['ubicacion' => 'footer', 'label' => 'Paquetes', 'ruta' => 'paquetes', 'orden' => 4],
                ['ubicacion' => 'footer', 'label' => 'Caminatas', 'ruta' => 'caminatas', 'orden' => 5],
            ];

            foreach ($items as $item) {
                MenuItem::query()->create($item + ['visible' => true, 'target' => '_self']);
            }
        }

        $datos = datos_empresa::query()->first();
        if ($datos) {
            $datos->fill(array_filter([
                'footer_texto' => $datos->footer_texto ?: Contenido::texto('footer.about'),
                'meta_title' => $datos->meta_title ?: 'MAGIC JOURNEYS PERU - Tours, Paquetes y Aventuras en Perú',
                'meta_description' => $datos->meta_description ?: 'Tours, caminatas y paquetes en Cusco y el Perú con Magic Journeys.',
                'url_frances' => $datos->url_frances ?: 'https://voyagesmagiquesperou.com/',
                'copyright' => $datos->copyright ?: 'Copyright '.date('Y').' Magic Journeys. All Rights Reserved.',
            ], fn ($value) => $value !== null && $value !== ''));
            $datos->save();
        }
    }
}
