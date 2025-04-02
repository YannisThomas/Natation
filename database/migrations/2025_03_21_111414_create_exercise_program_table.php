<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercise_program', function (Blueprint $table) {
            $table->id();

            // Utilisation des bons noms de tables en pluriel
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('exercise_id');

            // Optionnel : détails supplémentaires
            $table->integer('sets')->nullable();      // nb de séries
            $table->integer('reps')->nullable();      // nb de répétitions
            $table->integer('duration')->nullable();  // en secondes

            $table->timestamps();

            // Clés étrangères
            $table->foreign('program_id')->references('id')->on('program')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercise')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_program');
    }
};
