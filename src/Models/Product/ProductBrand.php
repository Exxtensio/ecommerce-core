<?php

namespace Exxtensio\EcommerceCore\Models\Product;

use Illuminate\Database\Eloquent\Relations;

class ProductBrand extends AbstractProductModel
{
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'description',
        'src',
        'meta_title',
        'meta_description',
    ];

    public function products(): Relations\HasMany
    {
        return $this->hasMany(Product::class, app('ecommerce')::getProductBrandId());
    }
}
