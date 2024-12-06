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
        Schema::table('delegates', function (Blueprint $table) {
            $table->foreignIdFor(\App\Office\Office::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delegate', function (Blueprint $table) {
            //
        });
    }
};
