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
        Schema::create(app('ecommerce')->getOrderItemTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceRelation('order', false, true);
            $table->ecommerceRelation('product');
            $table->integer('quantity');
            $table->decimal('price', config('ecommerce.migration.product_price_table.price_decimal_total'), config('ecommerce.migration.product_price_table.price_decimal_places'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getOrderItemTable());
    }
};
