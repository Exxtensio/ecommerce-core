<?php

namespace Sambu\Ecommerce\Providers\Includes;

use Illuminate\Support\ServiceProvider;
use Sambu\Ecommerce\RouteRegistration;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            if ($this->app->routesAreCached())
                return;

            (new RouteRegistration())
                ->withWebRoutes()
                ->withApiRoutes();
        });
    }

    public function register(): void {}
}
