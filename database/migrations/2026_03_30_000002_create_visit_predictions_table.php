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
        Schema::create('visit_predictions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->constrained('visits')->cascadeOnDelete();
            $table->enum('stage', ['initial', 'post_measurement'])->default('initial');
            $table->unsignedTinyInteger('predicted_priority');
            $table->decimal('tc_probability', 5, 4);
            $table->string('model_name')->nullable();
            $table->string('model_version')->nullable();
            $table->json('input_snapshot')->nullable();
            $table->timestamps();

            $table->index(['visit_id', 'stage', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_predictions');
    }
};
