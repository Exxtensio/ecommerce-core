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
        Schema::create(app('ecommerce')->getProductAttributeTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });

        $productSingular = app('ecommerce')->getProductTable(true);
        $attributeSingular = app('ecommerce')->getProductAttributeTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $attributeSingular);

        Schema::create($table, function (Blueprint $table) use ($productSingular, $attributeSingular) {
            $table->ecommercePrimaries($productSingular, $attributeSingular);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $productSingular = app('ecommerce')->getProductTable(true);
        $attributeSingular = app('ecommerce')->getProductAttributeTable(true);
        $table = $productSingular . '_' . str_replace('product_', '', $attributeSingular);

        Schema::dropIfExists(app('ecommerce')->getProductAttributeTable());
        Schema::dropIfExists($table);
    }
};
