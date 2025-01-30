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
        Schema::create('delegate_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Meal::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Delegate::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('for_date');
            $table->integer('meals_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegate_absences');
    }
};
