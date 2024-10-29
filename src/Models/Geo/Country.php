<?php

namespace Sambu\Ecommerce\Models\Geo;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool $active
 */
class Country extends AbstractGeoModel
{
    protected $fillable = [
        'name',
        'code',
        'active',
    ];

    public function scopeChangeActive(bool $value): void
    {
        $this->active = $value;

        $this->save();
    }

    public function currency(): BelongsTo
    {
        $singular = app('ecommerce')->getCurrencyTable(true);
        return $this->belongsTo(Currency::class, "{$singular}_id");
    }
}
