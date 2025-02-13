<?php

namespace Exxtensio\EcommerceCore\Models\Product;

class ProductPrice extends AbstractProductModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getProductId(),
            'country',
            'price',
        ];
        parent::__construct($attributes);
    }
}
