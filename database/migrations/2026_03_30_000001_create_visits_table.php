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
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('patient_name');
            $table->unsignedTinyInteger('age');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('arrival_with_ambulance')->default(false);
            $table->unsignedTinyInteger('ess_code');
            $table->unsignedTinyInteger('current_queue_priority')->nullable();
            $table->timestamp('priority_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
