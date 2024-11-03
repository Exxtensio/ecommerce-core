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
        Schema::create(app('ecommerce')->getCartTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('country', 3)->default(config('ecommerce.default.country'))->index();
            $table->timestamps();
        });

        Schema::create(app('ecommerce')->getCartItemTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceRelation('cart', false, true);
            $table->ecommerceRelation('product', false, true);
            $table->decimal('quantity', config('ecommerce.migration.product_stock_table.stock_decimal_total'), config('ecommerce.migration.product_stock_table.stock_decimal_places'))->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getCartItemTable());
        Schema::dropIfExists(app('ecommerce')->getCartTable());
    }
};
