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
        Schema::create(app('ecommerce')->getCurrencyTable(), function (Blueprint $table) {
            $table->ecommercePrimary();
            $table->string('name')->unique();
            $table->string('code', 3)->unique();
            $table->string('symbol', 7);
            $table->decimal('rate', 16, 4)->default(1);
            $table->decimal('fixed_rate', 16, 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(app('ecommerce')->getCurrencyTable());
    }
};
