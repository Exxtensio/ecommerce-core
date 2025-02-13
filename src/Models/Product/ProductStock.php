<?php

namespace Exxtensio\EcommerceCore\Models\Product;

class ProductStock extends AbstractProductModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getProductId(),
            'country',
            'stock',
        ];
        parent::__construct($attributes);
    }
}
