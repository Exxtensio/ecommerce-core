<?php

namespace Sambu\Ecommerce\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sambu\Ecommerce\Models\Geo\AbstractModel;

class Order extends AbstractModel
{
    protected $fillable = [
        'amount',
        'status',
        'payment_status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(config('ecommerce.migration.customer_table.model'), "user_id");
    }
}
