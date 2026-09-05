<?php

namespace Tests\Feature;

use Tests\TestCase;

class CmsPublicPagesTest extends TestCase
{
    public function test_home_is_successful(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_sitemap_is_xml(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('content-type', 'application/xml; charset=UTF-8')
            ->assertSee('urlset', false);
    }

    public function test_robots_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap:', false);
    }

    public function test_catalog_routes_are_successful(): void
    {
        $this->get('/tours')->assertOk();
        $this->get('/paquetes')->assertOk();
        $this->get('/caminatas')->assertOk();
        $this->get('/contacto')->assertOk();
        $this->get('/responsabilidad')->assertOk();
    }
}
