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
        Schema::create('products_living_mission', function (Blueprint $table) {
            $table->id();
            $table->double('price', 10, 6)->nullable();
            $table->double('daily_amount', 20, 6)->nullable();
            $table->foreignIdFor(\App\Product\Product::class)
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Living\Living::class)
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Mission\Mission::class)
                ->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_living_mission');
    }
};
