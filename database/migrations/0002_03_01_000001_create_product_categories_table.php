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
        Schema::create(app('ecommerce')->getProductCategoryTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->ecommerceParent();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('src')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $productSingular = app('ecommerce')->getProductTable(true);
        $categorySingular = app('ecommerce')->getProductCategoryTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $categorySingular);

        Schema::create($table, function (Blueprint $table) use ($productSingular, $categorySingular) {
            $table->ecommercePrimaries($productSingular, $categorySingular);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $productSingular = app('ecommerce')->getProductTable(true);
        $categorySingular = app('ecommerce')->getProductCategoryTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $categorySingular);

        Schema::dropIfExists(app('ecommerce')->getProductCategoryTable());
        Schema::dropIfExists($table);
    }
};
