<?php

namespace Sambu\Ecommerce\Models;

use Laravel\Sanctum\HasApiTokens;

class Artisan extends \App\Models\User
{
    use HasApiTokens;

    protected $table = 'users';
    protected string $role = 'artisan';

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];
}
