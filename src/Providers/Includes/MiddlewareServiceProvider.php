<?php

namespace Sambu\Ecommerce\Providers\Includes;

use Illuminate\Support\ServiceProvider;
use Sambu\Ecommerce\Http\Middleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('ecommerce-response', Middleware\EcommerceResponseMiddleware::class);
    }

    public function register(): void {}
}
