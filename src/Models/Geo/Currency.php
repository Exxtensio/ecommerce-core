<?php

namespace Sambu\Ecommerce\Models\Geo;

class Currency extends AbstractGeoModel
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'rate',
        'fixed_rate',
    ];
}
