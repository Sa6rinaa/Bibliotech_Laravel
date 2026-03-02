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
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('auteur');
            $table->year('annee')->nullable();
            $table->integer('nb_pages')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->text('resume')->nullable();
            $table->string('couverture')->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();

            // Index pour améliorer les recherches
            $table->index(['titre', 'auteur']);
            $table->index('disponible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};
