<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Support\ServiceProvider;
use Exxtensio\EcommerceCore\Http\Middleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('ecommerce-response', Middleware\EcommerceResponseMiddleware::class);
    }

    public function register(): void {}
}
