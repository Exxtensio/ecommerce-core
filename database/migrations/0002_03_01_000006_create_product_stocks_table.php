<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(app('ecommerce')->getProductStockTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceRelation('product');
            $table->string('country', 3)->default(config('ecommerce.default.country'))->index();
            $table->decimal(
                'stock',
                config('ecommerce.migration.product_stock_table.stock_decimal_total'),
                config('ecommerce.migration.product_stock_table.stock_decimal_places')
            );
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getProductStockTable());
    }
};
