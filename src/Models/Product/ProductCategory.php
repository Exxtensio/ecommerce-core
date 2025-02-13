<?php

namespace Exxtensio\EcommerceCore\Models\Product;

use Illuminate\Database\Eloquent\Relations;

class ProductCategory extends AbstractProductModel
{
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'description',
        'parent_id',
        'src',
    ];

    public function parent(): Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
