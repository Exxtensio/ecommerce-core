<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Support\ServiceProvider;

class LoadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('ecommerce', function () {
            return new \Exxtensio\EcommerceCore\Ecommerce();
        });

        $this->mergeConfigFrom(__DIR__.'/../../../config/ecommerce.php', 'ecommerce');
        $this->loadMigrationsFrom(__DIR__.'/../../../database/migrations');
    }

    public function boot(): void {}
}
