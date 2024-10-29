<?php

namespace Sambu\Ecommerce\Observers\Product;

use Sambu\Ecommerce\Models\Product\Product as ObserverModel;

class ProductObserver
{
    public function creating(ObserverModel $model): void
    {
        $model->prices()->create([
            'price' => $model->price,
            'product_id' => $model->id,
            'country' => config('ecommerce.default.country')
        ]);

        $model->stocks()->create([
            'stock' => $model->stock,
            'product_id' => $model->id,
            'country' => config('ecommerce.default.country')
        ]);

        $model->images()
            ->where('default', 1)
            ->update(['default' => 0]);

        $model->images()->create([
            'src' => $model->image,
            'product_id' => $model->id,
            'default' => 1
        ]);

        unset($model->price, $model->stock, $model->image);
    }

    public function created(ObserverModel $model): void
    {
        //
    }

    public function updated(ObserverModel $model): void
    {
        //
    }

    public function deleted(ObserverModel $model): void
    {
        //
    }

    public function restored(ObserverModel $model): void
    {
        //
    }

    public function forceDeleted(ObserverModel $model): void
    {
        //
    }
}
