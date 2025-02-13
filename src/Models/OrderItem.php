<?php

namespace Exxtensio\EcommerceCore\Models;

use Illuminate\Database\Eloquent\Relations;
use Exxtensio\EcommerceCore\Models\Product\Product;

class OrderItem extends AbstractSimpleModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getOrderId(),
            app('ecommerce')::getProductId(),
            'quantity',
            'price',
        ];
        parent::__construct($attributes);
    }

    protected $with = [
        'product'
    ];

    public function order(): Relations\BelongsTo
    {
        return $this->belongsTo(Order::class, app('ecommerce')::getOrderId());
    }

    public function product(): Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, app('ecommerce')::getProductId());
    }
}
