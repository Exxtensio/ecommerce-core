<?php

namespace Sambu\Ecommerce\Models\Product;

class ProductAttribute extends AbstractProductModel
{
    protected $fillable = [
        'key',
        'value'
    ];
}
