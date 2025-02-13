<?php

namespace Exxtensio\EcommerceCore\Models\Product;

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
