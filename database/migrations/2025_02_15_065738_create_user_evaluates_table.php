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
        Schema::create('user_evaluates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluated_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(\App\Evaluation\Evaluation::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Evaluation\EvaluateWeek::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Evaluation\EvaluateElement::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_evaluates');
    }
};
