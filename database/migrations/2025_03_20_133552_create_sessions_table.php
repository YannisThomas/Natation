<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Identifiant unique de la session
            $table->foreignId('user_id')->nullable()->index(); // Relation avec l'utilisateur (optionnel)
            $table->string('ip_address', 45)->nullable(); // Adresse IP
            $table->text('user_agent')->nullable(); // Information sur l'utilisateur (navigateur)
            $table->longText('payload'); // Données de session
            $table->integer('last_activity')->index(); // Dernière activité
            $table->timestamps(); // Crée les colonnes `created_at` et `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
}
