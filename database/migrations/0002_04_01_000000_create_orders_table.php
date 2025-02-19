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
        Schema::create(app('ecommerce')->getOrderTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('country', 3)->default(config('ecommerce.default.country'))->index();
            $table->decimal(
                'amount',
                config('ecommerce.migration.product_price_table.price_decimal_total'),
                config('ecommerce.migration.product_price_table.price_decimal_places')
            );
            $table->string('status')->default(config('ecommerce.migration.order_table.status_default'))->index();
            $table->string('payment_status')->default(config('ecommerce.migration.order_table.payment_status_default'))->index();
            $table->timestamps();
        });

        Schema::create(app('ecommerce')->getOrderItemTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceRelation('order', false, true);
            $table->ecommerceRelation('product', false, true);
            $table->decimal(
                'quantity',
                config('ecommerce.migration.product_stock_table.stock_decimal_total'),
                config('ecommerce.migration.product_stock_table.stock_decimal_places')
            );
            $table->decimal(
                'price',
                config('ecommerce.migration.product_price_table.price_decimal_total'),
                config('ecommerce.migration.product_price_table.price_decimal_places')
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getOrderItemTable());
        Schema::dropIfExists(app('ecommerce')->getOrderTable());
    }
};
