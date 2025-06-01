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
        Schema::table('exercise_program', function (Blueprint $table) {
            $table->integer('duration_completed')->nullable();
            $table->decimal('distance_completed', 10, 2)->nullable();
            $table->integer('repetitions_completed')->nullable();
            $table->decimal('weight_used', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->json('gps_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercise_program', function (Blueprint $table) {
            $table->dropColumn([
                'duration_completed',
                'distance_completed', 
                'repetitions_completed',
                'weight_used',
                'notes',
                'gps_data'
            ]);
        });
    }
};
