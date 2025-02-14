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
        Schema::create('task_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Task\Task::class)->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignIdFor(\App\Task\Stage::class)->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\User::class)->comment('The user who changed the task')->constrained()->onDelete('cascade')->cascadeOnUpdate();
            $table->text('note')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
