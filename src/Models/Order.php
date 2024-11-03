<?php

namespace Sambu\Ecommerce\Models;

use Illuminate\Database\Eloquent\Relations;

class Order extends AbstractSimpleModel
{
    protected $fillable = [
        'user_id',
        'country',
        'amount',
        'status',
        'payment_status',
    ];

    protected $with = [
        'items'
    ];

    public function items(): Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, app('ecommerce')::getOrderId());
    }

    public function customer(): Relations\BelongsTo
    {
        return $this->belongsTo(config('ecommerce.migration.customer_table.model'), 'user_id');
    }
}
