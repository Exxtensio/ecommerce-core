<?php

namespace Exxtensio\EcommerceCore\Observers\Product;

use Illuminate\Support\Facades\Storage;
use Exxtensio\EcommerceCore\Models\Product\ProductCategory as ObserverModel;

class ProductCategoryObserver
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
        $model->children()->delete();
    }

    public function restored(ObserverModel $model): void
    {
        $model->children()->withTrashed()->restore();
    }

    public function forceDeleted(ObserverModel $model): void
    {
        if($model->src)
            Storage::disk(config('filesystems.default'))
                ->delete($model->src);

        $model->children()->withTrashed()->forceDelete();
    }
}
