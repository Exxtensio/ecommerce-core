<?php

namespace Sambu\Ecommerce\Models\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations;

/*
|---------------------------------------------------------------------------------
| Type
|---------------------------------------------------------------------------------
|
| This option defines the product type.
|
| Available types: "digital", "quantity" (default), "weight", "volume", "length"
| Digital ("d"): product that involves downloading some content
| Quantity ("q"): quantitative product
| Weight ("w"): weight product
| Volume ("v"): liquid
| Length ("l"): product that is measured by length
|
|---------------------------------------------------------------------------------
| Digital & Quantity Unit
|---------------------------------------------------------------------------------
|
| Available unit: one ("o")
|
|---------------------------------------------------------------------------------
| Weight Unit
|---------------------------------------------------------------------------------
|
| Available unit:
| Megaton ("mt"), Ton ("t"), Kilogram ("kg"), Gram ("g"), Milligram ("mg"),
| Microgram ("mcg"), Long ton ("lt"), Short ton ("st"), Pound ("lb"),
| Ounce ("oz"), Drachm ("dr"), Grain ("gr"), Carat ("ct")
|
|---------------------------------------------------------------------------------
| Volume Unit
|---------------------------------------------------------------------------------
|
| Available unit:
| Cubic Meter ("m3"), Liter ("l"), Milliliter ("ml"), Cubic Centimeter ("cm3"),
| Cubic Decimeter ("dm3"), Cubic Foot ("ft3"), Cubic Inch ("in3"),
| Imperial Gallon ("imp-gal"), US Gallon ("gal"), Imperial Quart ("imp-qt"),
| US Quart ("qt"), Imperial Pint ("imp-pt"), US Pint ("pt"),
| Imperial Fluid Ounce ("imp-fl-oz"), US Fluid Ounce ("fl-oz")
|
|---------------------------------------------------------------------------------
| Length Unit
|---------------------------------------------------------------------------------
|
| Available unit:
| Kilometer ("km"), Meter ("m"), Centimeter ("cm"), Millimeter ("mm"),
| Micrometer ("mcm"), Nanometer ("nm"), Mile ("mi"), Yard ("yd"), Foot ("ft")
| Inch ("in"), Nautical Mile ("nmi")
|
*/
class Product extends AbstractProductModel
{
    const TYPE_DIGITAL = 'd', TYPE_QUANTITY = 'q',
        TYPE_WEIGHT = 'w', TYPE_VOLUME = 'v',
        TYPE_LENGTH = 'l';

    const DEFAULT_TYPE = 'q', DEFAULT_QUANTITY_UNIT = 'o',
        DEFAULT_DIGITAL_UNIT = 'o', DEFAULT_WEIGHT_UNIT = 'kg',
        DEFAULT_VOLUME_UNIT = 'l', DEFAULT_LENGTH_UNIT = 'm';

    const DIGITAL_UNITS = ['o'], QUANTITY_UNITS = ['o'],
        WEIGHT_UNITS = ['mt','t','kg','g','mg','mcg','lt','st','lb','oz','dr','gr','ct'],
        VOLUME_UNITS = ['m3','l','ml','cm3','dm3','ft3','in3','imp-gal','gal','imp-qt','qt','imp-pt','pt','imp-fl-oz','fl-oz'],
        LENGTH_UNITS = ['km','m','cm','mm','mcm','nm','mi','yd','ft','in','nmi'];

    protected $fillable = [
        'product_brand_id',
        'type',
        'unit',
        'step',
        'name',
        'slug',
        'summary',
        'description',
        'status',
        'price',
        'stock',
        'image',
    ];

    protected $casts = [
        'step' => 'integer',
        'default_price' => 'decimal',
        'default_stock' => 'decimal',
    ];

    protected $with = [
        'prices',
        'stocks',
        'images',
    ];

    public function brand(): Relations\BelongsTo
    {
        $singular = app('ecommerce')::getProductBrandTable(true);
        return $this->belongsTo(ProductBrand::class, "{$singular}_id");
    }

    public function categories(): Relations\BelongsToMany
    {
        $productSingular = app('ecommerce')::getProductTable(true);
        $categorySingular = app('ecommerce')::getProductCategoryTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $categorySingular);
        return $this->belongsToMany(ProductCategory::class, $table, "{$productSingular}_id", "{$categorySingular}_id");
    }

    public function attributes(): Relations\BelongsToMany
    {
        $productSingular = app('ecommerce')::getProductTable(true);
        $attributeSingular = app('ecommerce')::getProductAttributeTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $attributeSingular);
        return $this->belongsToMany(ProductAttribute::class, $table, "{$productSingular}_id", "{$attributeSingular}_id");
    }

    public function images(): Relations\HasMany
    {
        $singular = app('ecommerce')::getProductTable(true);
        return $this->hasMany(ProductImage::class, "{$singular}_id");
    }

    public function prices(): Relations\HasMany
    {
        $singular = app('ecommerce')::getProductTable(true);
        return $this->hasMany(ProductPrice::class, "{$singular}_id");
    }

    public function stocks(): Relations\HasMany
    {
        $singular = app('ecommerce')::getProductTable(true);
        return $this->hasMany(ProductStock::class, "{$singular}_id");
    }
}
