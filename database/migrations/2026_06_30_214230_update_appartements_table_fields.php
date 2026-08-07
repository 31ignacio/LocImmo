<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appartements', function (Blueprint $table) {
            // ── À AJOUTER ──
            // Terrain
            $table->decimal('terrain_largeur', 10, 2)->nullable()->after('surface_bureau');
            $table->decimal('terrain_longueur', 10, 2)->nullable()->after('terrain_largeur');
            $table->string('titre_foncier')->nullable()->after('terrain_longueur');
            $table->text('autres_caracteristiques_terrain')->nullable()->after('titre_foncier');

            // Équipements absents (bureau / boutique / résidentiel)
            $table->string('brasseur')->default('Non')->after('terasse');     // résidentiel + boutique + bureau
            $table->string('salle_conf')->default('Non')->after('brasseur'); // bureau uniquement
            $table->string('vitrine')->default('Non')->after('salle_conf'); // boutique uniquement

            // ── À RETIRER (obsolètes / inutilisées par le nouveau formulaire) ──
            $table->dropColumn('salleBain');       // remplacé par nombreSalleBain
            $table->dropColumn('compteur_perso');  // remplacé par compteur_eau / compteur_elec
            $table->dropColumn('surface_totale');  // doublon de "surface", source de confusion
        });
    }

    public function down(): void
    {
        Schema::table('appartements', function (Blueprint $table) {
            $table->dropColumn(['terrain_largeur','terrain_longueur','titre_foncier','autres_caracteristiques_terrain','brasseur','salle_conf','vitrine']);
            $table->integer('salleBain')->default(0);
            $table->string('compteur_perso')->default('Non');
            $table->integer('surface_totale')->nullable();
        });
    }
};