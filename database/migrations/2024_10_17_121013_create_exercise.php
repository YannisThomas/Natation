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
        Schema::create('exercise', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
            $table->string('type', 50)->nullable();
            $table->tinyInteger('duration')->nullable();
            $table->string('description', 1000)->nullable();
            $table->smallInteger('distance')->nullable();
            $table->smallInteger('weight')->nullable();
            $table->smallInteger('repetition')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise');
    }
};
