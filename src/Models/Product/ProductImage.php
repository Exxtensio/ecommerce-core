<?php

namespace Sambu\Ecommerce\Models\Product;

class ProductImage extends AbstractProductModel
{
    protected $fillable = [
        'product_id',
        'src',
        'default'
    ];
}
