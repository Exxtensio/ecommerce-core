<?php

namespace Exxtensio\EcommerceCore\Models;

use Illuminate\Database\Eloquent\Relations;
use Exxtensio\EcommerceCore\Models\Product\Product;

class CartItem extends AbstractSimpleModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getCartId(),
            app('ecommerce')::getProductId(),
            'quantity'
        ];
        parent::__construct($attributes);
    }

    protected $with = [
        'product',
    ];

    public function cart(): Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class, app('ecommerce')::getCartId());
    }

    public function product(): Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, app('ecommerce')::getProductId());
    }
}
