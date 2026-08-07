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
        Schema::table('appartements', function (Blueprint $table) {

            // Géolocalisation (nullable)
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Pièces détaillées (remplace/complète l'ancien salleBain)
            $table->unsignedTinyInteger('nombreSalon')->default(0);
            $table->unsignedTinyInteger('nombreChambre')->default(0);
            $table->unsignedTinyInteger('nombreSalleBain')->default(0);
            // (nombrePieces existe déjà dans votre table)

            // Nouveaux Oui/Non
            $table->string('sanitaire')->default('Non');
            $table->string('proprio_vit')->default('Non');
            $table->string('compteur_perso')->default('Non');

            // Vidéo (nullable)
            $table->string('video')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appartements', function (Blueprint $table) {
            //
        });
    }
};
