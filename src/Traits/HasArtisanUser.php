<?php

namespace Exxtensio\EcommerceCore\Traits;

trait HasArtisanUser
{
    public static function isArtisanEmailExist() : bool
    {
        return !empty(config('ecommerce.artisan.email'));
    }

    public static function isArtisanNameExist() : bool
    {
        return !empty(config('ecommerce.artisan.name'));
    }

    public static function isArtisanPasswordExist() : bool
    {
        return !empty(config('ecommerce.artisan.password'));
    }
}
