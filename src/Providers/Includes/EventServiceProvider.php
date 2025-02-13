<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Support\ServiceProvider;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Observers;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Models\Product\ProductCategory::observe(Observers\Product\ProductCategoryObserver::class);
        Models\Product\ProductBrand::observe(Observers\Product\ProductBrandObserver::class);
        Models\Product\Product::observe(Observers\Product\ProductObserver::class);
    }

    public function register(): void {}
}
