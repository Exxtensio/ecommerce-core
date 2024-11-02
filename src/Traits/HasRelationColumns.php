<?php

namespace Sambu\Ecommerce\Traits;

use Illuminate\Support\Str;

trait HasRelationColumns
{
    public static function getCurrencyId(): string
    {
        return Str::singular(config('ecommerce.migration.currency_table.name')) . '_id';
    }

    public static function getCountryId(): string
    {
        return Str::singular(config('ecommerce.migration.country_table.name')). '_id';
    }

    public static function getProductCategoryId(): string
    {
        $productTable = Str::singular(config('ecommerce.migration.product_table.name'));
        $categoryTable = str_replace('product_', '', Str::singular(config('ecommerce.migration.product_category_table.name')));

        return "{$productTable}_{$categoryTable}_id";
    }

    public static function getProductId(): string
    {
        return Str::singular(config('ecommerce.migration.product_table.name')) . '_id';
    }

    public static function getProductBrandId(): string
    {
        $productTable = Str::singular(config('ecommerce.migration.product_table.name'));
        $brandTable = str_replace('product_', '', Str::singular(config('ecommerce.migration.product_brand_table.name')));

        return "{$productTable}_{$brandTable}_id";
    }
}
