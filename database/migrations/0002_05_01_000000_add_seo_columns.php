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
        Schema::table(app('ecommerce')->getProductBrandTable(), function (Blueprint $table) {
            $table->text('meta_description')->after('description')->nullable();
            $table->string('meta_title')->after('description')->nullable();
        });

        Schema::table(app('ecommerce')->getProductCategoryTable(), function (Blueprint $table) {
            $table->text('meta_description')->after('description')->nullable();
            $table->string('meta_title')->after('description')->nullable();
        });

        Schema::table(app('ecommerce')->getProductTable(), function (Blueprint $table) {
            $table->text('meta_description')->after('description')->nullable();
            $table->string('meta_title')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
