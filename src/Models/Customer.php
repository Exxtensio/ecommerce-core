<?php

namespace Sambu\Ecommerce\Models;

use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, $value)
 */
class Customer extends \App\Models\User
{
    use HasApiTokens;

    protected $table = 'users';
    protected string $role = 'customer';

    public static function findByEmail($value)
    {
        return self::where('email', $value)->first();
    }
}
