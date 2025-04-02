<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname'); // ✅ Prénom
            $table->string('lastname'); // ✅ Nom
            $table->string('email')->unique(); // ✅ Email unique
            $table->string('phone')->nullable(); // ✅ Téléphone facultatif
            $table->timestamp('email_verified_at')->nullable(); // ✅ Vérification email
            $table->string('password'); // ✅ Mot de passe
            $table->rememberToken(); // ✅ Token de session
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // ✅ Rôle obligatoire
            $table->foreignId('coach_id')->nullable()->constrained('users')->onDelete('cascade'); // ✅ Coach (peut être null)
            $table->timestamps(); // ✅ Date de création et mise à jour
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

