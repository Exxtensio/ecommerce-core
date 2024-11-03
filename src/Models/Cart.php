<?php

namespace Sambu\Ecommerce\Models;

use Illuminate\Database\Eloquent\Relations;

class Cart extends AbstractSimpleModel
{
    protected $fillable = [
        'user_id',
        'country'
    ];

    protected $with = [
        'items'
    ];

    public function items(): Relations\HasMany
    {
        return $this->hasMany(CartItem::class, app('ecommerce')::getCartId());
    }
}
