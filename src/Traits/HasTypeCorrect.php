<?php

namespace Exxtensio\EcommerceCore\Traits;

trait HasTypeCorrect
{
    public static function isPrimaryTypeCorrect() : bool
    {
        return in_array(
            config('ecommerce.migration.primary') ?? null,
            ['id', 'ulid', 'uuid'],
            true
        );
    }
}
