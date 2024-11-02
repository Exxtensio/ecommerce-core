<?php

namespace Sambu\Ecommerce\Models\Product;

class ProductImage extends AbstractProductModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getProductId(),
            'src',
            'default'
        ];
        parent::__construct($attributes);
    }
}
