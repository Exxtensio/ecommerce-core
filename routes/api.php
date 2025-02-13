<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\ProductCategoryApiController::class)
        ->prefix('product-categories')
        ->name('product-categories.')
        ->group(function () {
            Route::get('', 'index')->name('index'); // ToDo pagination, offset, limit ...
            Route::get('{id}', 'show')->name('show');
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::patch('{id}/restore', 'restore')->name('restore');
            Route::delete('{id}/force-delete', 'forceDelete')->name('force-delete');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\ProductAttributeApiController::class)
        ->prefix('product-attributes')
        ->name('product-attributes.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('{id}', 'show')->name('show');
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::patch('{id}/restore', 'restore')->name('restore');
            Route::delete('{id}/force-delete', 'forceDelete')->name('force-delete');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\ProductBrandApiController::class)
        ->prefix('product-brands')
        ->name('product-brands.')
        ->group(function () {
            Route::get('', 'index')->name('index'); // ToDo pagination, offset, limit ...
            Route::get('{id}', 'show')->name('show');
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::patch('{id}/restore', 'restore')->name('restore');
            Route::delete('{id}/force-delete', 'forceDelete')->name('force-delete');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\ProductApiController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::get('', 'index')->name('index'); // ToDo by Brand, by Category ...
            Route::get('{id}', 'show')->name('show');
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::patch('{id}/restore', 'restore')->name('restore');
            Route::delete('{id}/force-delete', 'forceDelete')->name('force-delete');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\ProductReviewApiController::class)
        ->prefix('product-reviews')
        ->name('product-reviews.')
        ->group(function () {
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::patch('{id}/restore', 'restore')->name('restore');
            Route::delete('{id}/force-delete', 'forceDelete')->name('force-delete');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\Relations\Product\ProductCategoryApiController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::post('{id}/product-categories', 'attach')->name('attach.product-category');
            Route::delete('{id}/product-categories', 'detach')->name('detach.product-category');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\Relations\Product\ProductAttributeApiController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::post('{id}/product-attributes', 'attach')->name('attach.product-attribute');
            Route::delete('{id}/product-attributes', 'detach')->name('detach.product-attribute');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\Relations\Product\ProductInventoryApiController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::post('{id}/product-inventory', 'store')->name('store.product-inventory');
            Route::patch('{id}/product-inventory', 'update')->name('update.product-inventory');
            Route::delete('{id}/product-inventory', 'destroy')->name('destroy.product-inventory');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\Relations\Product\ProductImageApiController::class)
        ->prefix('products')
        ->name('products.')
        ->group(function () {
            Route::post('{id}/product-images', 'store')->name('store.product-image');
            Route::delete('{id}/product-images/{imageId}', 'destroy')->name('destroy.product-image');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\CartApiController::class)
        ->prefix('carts')
        ->name('carts.')
        ->group(function () {
            Route::get('{id}', 'show')->name('show');
            Route::post('', 'store')->name('store');
            Route::delete('{id}', 'destroy')->name('destroy');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\CartItemApiController::class)
        ->prefix('cart-items')
        ->name('cart-items.')
        ->group(function () {
            Route::post('', 'store')->name('store');
            Route::patch('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');
        });

    Route::controller(\Exxtensio\EcommerceCore\Http\Controllers\OrderApiController::class)
        ->prefix('orders')
        ->name('orders.')
        ->group(function () {
            Route::post('', 'store')->name('store');
            Route::delete('{id}', 'destroy')->name('destroy');
        });
});


