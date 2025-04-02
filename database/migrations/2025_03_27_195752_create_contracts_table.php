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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('project_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('contract_amount_without_tax', 15, 2)->nullable();
            $table->string('extension_period')->nullable();
            $table->decimal('extended_amount_without_tax', 15, 2)->nullable();
            $table->decimal('tax_percentage', 5, 2)->nullable();
            $table->decimal('modified_tax', 15, 2)->nullable();
            $table->decimal('deduction_ratio', 5, 2)->nullable();
            $table->text('note')->nullable();
            $table->date('commission_date')->nullable();
            $table->date('award_date')->nullable();
            $table->date('contract_signing_date')->nullable();
            $table->foreignIdFor(\App\Models\ContractType::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
