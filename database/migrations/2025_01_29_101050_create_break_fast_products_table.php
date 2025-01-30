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
        Schema::create('break_fast_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Product\Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('daily_amount', 10, 6)->nullable();
            $table->float('price', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('break_fast_products');
    }
};
