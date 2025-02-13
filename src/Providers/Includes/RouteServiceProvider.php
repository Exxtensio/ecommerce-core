<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Support\ServiceProvider;
use Exxtensio\EcommerceCore\RouteRegistration;

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
