<?php

namespace Exxtensio\EcommerceCore\Models\Product;

class ProductReview extends AbstractProductModel
{
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            'user_id',
            app('ecommerce')::getProductId(),
            'rating',
            'comment',
        ];
        parent::__construct($attributes);
    }
}
