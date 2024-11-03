<?php

namespace Sambu\Ecommerce\Traits;

use Illuminate\Support\Str;

trait HasTables
{
    public static function getCurrencyTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.currency_table.name'));
        return config('ecommerce.migration.currency_table.name');
    }

    public static function getCountryTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.country_table.name'));
        return config('ecommerce.migration.country_table.name');
    }

    public static function getProductCategoryTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_category_table.name'));
        return config('ecommerce.migration.product_category_table.name');
    }

    public static function getProductTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_table.name'));
        return config('ecommerce.migration.product_table.name');
    }

    public static function getProductBrandTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_brand_table.name'));
        return config('ecommerce.migration.product_brand_table.name');
    }

    public static function getProductAttributeTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_attribute_table.name'));
        return config('ecommerce.migration.product_attribute_table.name');
    }

    public static function getProductReviewTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_review_table.name'));
        return config('ecommerce.migration.product_review_table.name');
    }

    public static function getProductImageTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_image_table.name'));
        return config('ecommerce.migration.product_image_table.name');
    }

    public static function getProductPriceTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_price_table.name'));
        return config('ecommerce.migration.product_price_table.name');
    }

    public static function getProductStockTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.product_stock_table.name'));
        return config('ecommerce.migration.product_stock_table.name');
    }

    public static function getCartTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.cart_table.name'));
        return config('ecommerce.migration.cart_table.name');
    }

    public static function getCartItemTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.cart_item_table.name'));
        return config('ecommerce.migration.cart_item_table.name');
    }

    public static function getOrderTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.order_table.name'));
        return config('ecommerce.migration.order_table.name');
    }

    public static function getOrderItemTable($singular = false)
    {
        if($singular) return Str::singular(config('ecommerce.migration.order_item_table.name'));
        return config('ecommerce.migration.order_item_table.name');
    }
}
