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
        Schema::create(app('ecommerce')->getProductTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceRelation('product_brand', true, true);
            $table->char('type', 1);
            $table->char('unit', 12);
            $table->integer('step')->default(1);

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(config('ecommerce.migration.product_table.status_default'))->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getProductTable());
    }
};
