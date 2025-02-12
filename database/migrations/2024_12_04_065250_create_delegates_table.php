<?php

use App\Product\FoodType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delegates', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('name');
            $table->integer('benefits')->default(0);
            $table->string('institution')->nullable();
            $table->string('rank')->nullable();
            $table->foreignIdFor(FoodType::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Office\Office::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegates');
    }
};
