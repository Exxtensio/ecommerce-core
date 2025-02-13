<?php

namespace Exxtensio\EcommerceCore\Models\Product;

use Illuminate\Database\Eloquent\Relations;

/*
|---------------------------------------------------------------------------------
| Type
|---------------------------------------------------------------------------------
|
| This option defines the product type.
|
| Available types: "digital", "quantity" (default), "weight", "volume", "length"
| Digital ("dig"): product that involves downloading some content
| Quantity ("qty"): quantitative product
| Weight ("wt"): weight product
| Volume ("vol"): liquid
| Length ("len"): product that is measured by length
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
    const TYPE_DIGITAL = 'dig', TYPE_QUANTITY = 'qty',
        TYPE_WEIGHT = 'wt', TYPE_VOLUME = 'vol',
        TYPE_LENGTH = 'len';

    const DEFAULT_TYPE = 'qty', DEFAULT_QUANTITY_UNIT = 'o',
        DEFAULT_DIGITAL_UNIT = 'o', DEFAULT_WEIGHT_UNIT = 'kg',
        DEFAULT_VOLUME_UNIT = 'l', DEFAULT_LENGTH_UNIT = 'm';

    const DIGITAL_UNITS = ['o'], QUANTITY_UNITS = ['o'],
        WEIGHT_UNITS = ['mt','t','kg','g','mg','mcg','lt','st','lb','oz','dr','gr','ct'],
        VOLUME_UNITS = ['m3','l','ml','cm3','dm3','ft3','in3','imp-gal','gal','imp-qt','qt','imp-pt','pt','imp-fl-oz','fl-oz'],
        LENGTH_UNITS = ['km','m','cm','mm','mcm','nm','mi','yd','ft','in','nmi'];

    const ACRONYM = [
        'dig' => 'digital',
        'qty' => 'quantity',
        'wt' => 'weight',
        'vol' => 'volume',
        'len' => 'length',
        'o' => 'one',
        'mt' => 'metric ton',
        't' => 'ton',
        'kg' => 'kilogram',
        'g' => 'gram',
        'mg' => 'milligram',
        'mcg' => 'microgram',
        'lt' => 'long ton',
        'st' => 'short ton',
        'lb' => 'pound',
        'oz' => 'ounce',
        'dr' => 'dram',
        'gr' => 'grain',
        'ct' => 'carat',
        'm3' => 'cubic meter',
        'l' => 'liter',
        'ml' => 'milliliter',
        'cm3' => 'cubic centimeter',
        'dm3' => 'cubic decimeter',
        'ft3' => 'cubic foot',
        'in3' => 'cubic inch',
        'imp-gal' => 'imperial gallon',
        'gal' => 'gallon',
        'imp-qt' => 'imperial quart',
        'qt' => 'quart',
        'imp-pt' => 'imperial pint',
        'pt' => 'pint',
        'imp-fl-oz' => 'imperial fluid ounce',
        'fl-oz' => 'fluid ounce',
        'km' => 'kilometer',
        'm' => 'meter',
        'cm' => 'centimeter',
        'mm' => 'millimeter',
        'mcm' => 'micrometer',
        'nm' => 'nanometer',
        'mi' => 'mile',
        'yd' => 'yard',
        'ft' => 'foot',
        'in' => 'inch',
        'nmi' => 'nautical mile'
    ];

    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            app('ecommerce')::getProductBrandId(),
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
        parent::__construct($attributes);
    }

    protected $with = [
        'prices',
        'stocks',
        'images',
        'brand',
        'categories',
        'attributes',
        'reviews'
    ];

    public function brand(): Relations\BelongsTo
    {
        return $this->belongsTo(ProductBrand::class, app('ecommerce')::getProductBrandId());
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
        return $this->hasMany(ProductImage::class, app('ecommerce')::getProductId());
    }

    public function prices(): Relations\HasMany
    {
        return $this->hasMany(ProductPrice::class, app('ecommerce')::getProductId());
    }

    public function stocks(): Relations\HasMany
    {
        return $this->hasMany(ProductStock::class, app('ecommerce')::getProductId());
    }

    public function reviews(): Relations\HasMany
    {
        return $this->hasMany(ProductReview::class, app('ecommerce')::getProductId());
    }
}
