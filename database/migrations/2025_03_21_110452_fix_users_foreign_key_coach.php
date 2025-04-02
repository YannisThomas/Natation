<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // D'abord on supprime la contrainte existante si elle bug
            $table->dropForeign(['coach_id']); // silencieux si elle n’existe pas

            // Ensuite on la recrée proprement
            $table->foreign('coach_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['coach_id']);
        });
    }
};

