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
        Schema::create('contains', function (Blueprint $table) {
            $table->string('location_id', 50);
            $table->unsignedSmallInteger('id');
            $table->primary(['location_id', 'id']);
            $table->foreign('location_id')->references('location_id')->on('locations');
            $table->foreign('id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contains');
    }
};
