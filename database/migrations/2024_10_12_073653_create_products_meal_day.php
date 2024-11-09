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
        Schema::create('products_day_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Product\ProductLivingMission::class)->constrained('products_living_mission')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Day::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Meal::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_meal_day');
    }
};
