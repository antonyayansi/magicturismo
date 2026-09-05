<?php

namespace App\Providers;

use App\Models\Contenido;
use App\Models\MenuItem;
use App\Services\SiteSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('contenido', function ($expression) {
            return "<?php echo e(\\App\\Models\\Contenido::texto($expression)); ?>";
        });

        View::composer('layout.es', function ($view) {
            try {
                $menuHeader = MenuItem::forLocation('header');
                $menuFooter = MenuItem::forLocation('footer');
            } catch (\Throwable $e) {
                $menuHeader = collect();
                $menuFooter = collect();
            }

            $view->with([
                'datos' => $view->offsetExists('datos') ? $view->offsetGet('datos') : SiteSettings::datos(),
                'tours' => $view->offsetExists('tours') ? $view->offsetGet('tours') : SiteSettings::navTours(),
                'paquetes' => $view->offsetExists('paquetes') ? $view->offsetGet('paquetes') : SiteSettings::navPaquetes(),
                'menuHeader' => $menuHeader,
                'menuFooter' => $menuFooter,
            ]);
        });
    }
}
