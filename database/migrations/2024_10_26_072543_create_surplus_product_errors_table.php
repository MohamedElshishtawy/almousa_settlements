<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surplus_product_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Report\Surplus::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Product\StaticProduct::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('surplus_benefits')->nullable();
            $table->float('surplus_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surplus_product_errors');
    }
};
