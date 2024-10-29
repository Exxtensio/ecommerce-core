<?php

namespace Sambu\Ecommerce\Models\Product;

use Illuminate\Database\Eloquent\Relations;

class ProductBrand extends AbstractProductModel
{
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'description',
        'src',
    ];

    public function products(): Relations\HasMany
    {
        $singular = app('ecommerce')::getProductBrandTable(true);
        return $this->hasMany(Product::class, "{$singular}_id");
    }
}
