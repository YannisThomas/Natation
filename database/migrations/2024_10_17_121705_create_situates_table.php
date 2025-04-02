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
        Schema::create('situates', function (Blueprint $table) {
            $table->string('exercise_id', 50);
            $table->string('location_id', 50);
            $table->primary(['exercise_id', 'location_id']);
            $table->foreign('exercise_id')->references('exercise_id')->on('exercise');
            $table->foreign('location_id')->references('location_id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situates');
    }
};
