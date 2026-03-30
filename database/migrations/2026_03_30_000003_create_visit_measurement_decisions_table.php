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
        Schema::create('visit_measurement_decisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->constrained('visits')->cascadeOnDelete();
            $table->enum('decision_type', ['vp', 'bg']);
            $table->decimal('measurement_affects_tc_probability', 5, 4);
            $table->boolean('should_measure');
            $table->string('model_name')->nullable();
            $table->string('model_version')->nullable();
            $table->json('input_snapshot')->nullable();
            $table->timestamps();

            $table->index(['visit_id', 'decision_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_measurement_decisions');
    }
};
