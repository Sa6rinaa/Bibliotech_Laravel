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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('courriel')->unique();
            $table->timestamp('courriel_verifie_le')->nullable();
            $table->string('mot_de_passe');
            $table->enum('role', ['utilisateur', 'admin'])->default('utilisateur');
            $table->rememberToken();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('courriel');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
