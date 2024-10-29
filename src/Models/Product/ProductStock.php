<?php

namespace Sambu\Ecommerce\Models\Product;

class ProductStock extends AbstractProductModel
{
    protected $fillable = [
        'product_id',
        'country',
        'stock',
    ];
}
