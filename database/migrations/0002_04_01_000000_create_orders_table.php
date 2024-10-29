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
            $table->ecommerceRelation('country', false, true);
            $table->decimal('amount', config('ecommerce.migration.order_table.amount_decimal_total'), config('ecommerce.migration.order_table.amount_decimal_places'));
            $table->string('status')->default(config('ecommerce.migration.order_table.status_default'))->index();
            $table->string('payment_status')->default(config('ecommerce.migration.order_table.payment_status_default'))->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getOrderTable());
    }
};
