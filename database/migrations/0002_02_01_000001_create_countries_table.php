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
        Schema::create(app('ecommerce')->getCountryTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->string('name')->unique();
            $table->string('code', 3)->unique();
            $table->boolean('active')->default(0);
            $table->ecommerceRelation('currency', true, true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getCountryTable());
    }
};
