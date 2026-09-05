<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pagina;
use App\Models\Paquetes;
use App\Services\SiteSettings;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('site.sitemap', 3600, function () {
            $urls = [
                ['loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
                ['loc' => route('tours'), 'changefreq' => 'weekly', 'priority' => '0.9'],
                ['loc' => route('caminatas'), 'changefreq' => 'weekly', 'priority' => '0.9'],
                ['loc' => route('paquetes'), 'changefreq' => 'weekly', 'priority' => '0.9'],
                ['loc' => route('contacto'), 'changefreq' => 'monthly', 'priority' => '0.7'],
                ['loc' => route('responsabilidad'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ];

            foreach (Paquetes::query()->publicados()->orderByDesc('updated_at')->get(['slug', 'tipo', 'updated_at']) as $paquete) {
                $urls[] = [
                    'loc' => $paquete->publicUrl(),
                    'lastmod' => optional($paquete->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }

            foreach (Categoria::query()->orderBy('nombre')->get(['slug', 'updated_at']) as $categoria) {
                $urls[] = [
                    'loc' => route('categorias', $categoria->slug),
                    'lastmod' => optional($categoria->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }

            if (Schema::hasTable('paginas')) {
                foreach (Pagina::query()->publicadas()->get(['slug', 'updated_at']) as $pagina) {
                    if ($pagina->slug === 'contacto') {
                        continue;
                    }

                    $urls[] = [
                        'loc' => route('pagina', $pagina->slug),
                        'lastmod' => optional($pagina->updated_at)->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ];
                }
            }

            $body = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $body .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

            foreach ($urls as $url) {
                $body .= "  <url>\n";
                $body .= '    <loc>'.e($url['loc'])."</loc>\n";
                if (! empty($url['lastmod'])) {
                    $body .= '    <lastmod>'.e($url['lastmod'])."</lastmod>\n";
                }
                $body .= '    <changefreq>'.e($url['changefreq'])."</changefreq>\n";
                $body .= '    <priority>'.e($url['priority'])."</priority>\n";
                $body .= "  </url>\n";
            }

            $body .= '</urlset>';

            return $body;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $datos = SiteSettings::datos();
        $name = $datos->nombre ?? 'Magic Journeys Peru';

        $txt = implode("\n", [
            '# '.$name,
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /login',
            'Disallow: /register',
            '',
            'Sitemap: '.url('/sitemap.xml'),
            '',
        ]);

        return response($txt, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
