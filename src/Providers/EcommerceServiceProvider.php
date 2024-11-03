<?php

namespace Sambu\Ecommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum;

/**
 * ToDo
 * carts
 * cart_items
 * orders
 * order_items
 */
class EcommerceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(Includes\LoadServiceProvider::class);
        $this->app->register(Includes\ConsoleServiceProvider::class);
        $this->app->register(Includes\ValidateServiceProvider::class);
        $this->app->register(Includes\MacroServiceProvider::class);
        $this->app->register(Includes\RouteServiceProvider::class);
        $this->app->register(Includes\EventServiceProvider::class);
        $this->app->register(Includes\MiddlewareServiceProvider::class);
        Sanctum\Sanctum::usePersonalAccessTokenModel(Sanctum\PersonalAccessToken::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/ecommerce.php' => config_path('ecommerce.php'),
        ]);
    }
}
