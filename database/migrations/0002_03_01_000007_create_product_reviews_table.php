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
        Schema::create(app('ecommerce')->getProductReviewTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->unsignedBigInteger('user_id')->index();
            $table->ecommerceRelation('product');
            $table->enum('rating', ['1', '2', '3', '4', '5'])->default('5');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getProductReviewTable());
    }
};
