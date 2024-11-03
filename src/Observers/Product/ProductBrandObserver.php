<?php

namespace Sambu\Ecommerce\Observers\Product;

use Illuminate\Support\Facades\Storage;
use Sambu\Ecommerce\Models\Product\ProductBrand as ObserverModel;

class ProductBrandObserver
{
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
//        $model->products()->dissociate($model);
    }

    public function restored(ObserverModel $model): void
    {
        //
    }

    public function forceDeleted(ObserverModel $model): void
    {
        if($model->src)
            Storage::disk(config('filesystems.default'))
                ->delete($model->src);
    }
}
