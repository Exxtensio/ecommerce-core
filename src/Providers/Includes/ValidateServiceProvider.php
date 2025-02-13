<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Exception;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function boot(): void
    {
        if(!$this->app->make('ecommerce')->isPrimaryTypeCorrect())
            throw new \Exception("The `id` column type is invalid. It should be `id`, `ulid` or `uuid` type. Follow to ecommerce.php `migration.primary` to solve the problem.");

        if(!$this->app->make('ecommerce')->isArtisanEmailExist() || !$this->app->make('ecommerce')->isArtisanNameExist() || !$this->app->make('ecommerce')->isArtisanPasswordExist())
            throw new \Exception("The user artisan is missing or the data provided is incorrect. Follow to `artisan` → `config/ecommerce.php` to solve the problem.");
    }

    public function register(): void {}
}
