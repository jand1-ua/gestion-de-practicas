<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paginación con estilos propios (sin depender de Tailwind/Bootstrap)
        Paginator::defaultView('partials.pagination');
        Paginator::defaultSimpleView('partials.pagination-simple');
    }
}
