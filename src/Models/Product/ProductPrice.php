<?php

namespace Sambu\Ecommerce\Models\Product;

class ProductPrice extends AbstractProductModel
{
    protected $fillable = [
        'product_id',
        'country',
        'price',
    ];
}
