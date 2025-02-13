<?php

namespace Exxtensio\EcommerceCore;

use Illuminate\Support\Facades\Route;

class RouteRegistration
{
    public function withWebRoutes(): RouteRegistration
    {
        Route::middleware(config('ecommerce.routes.web.middlewares'))
            ->name('ecommerce.web.')
            ->group(__DIR__.'/../routes/web.php');

        return $this;
    }

    public function withApiRoutes(): RouteRegistration
    {
        Route::middleware(config('ecommerce.routes.api.middlewares'))
            ->name('ecommerce.api.')
            ->prefix(config('ecommerce.routes.api.prefix'))
            ->group(__DIR__.'/../routes/api.php');

        return $this;
    }
}
