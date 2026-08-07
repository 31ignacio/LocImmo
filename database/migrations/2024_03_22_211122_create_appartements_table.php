<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
 
            /* ── Type & catégorie ── */
            $table->string('type');                      // Maison | Appartement | Bureaux | Boutique
            $table->string('categorie');                 // louer | vendre
            $table->string('duree');                     // 30 Jours | 90 Jours
 
            /* ── Adresse ── */
            $table->string('departement');
            $table->string('commune')->nullable();
            $table->string('quartier');
 
            /* ── Caractéristiques ── */
            $table->float('surface')->nullable();        // m² — tous types
            $table->integer('nombrePieces')->default(1); // remplace nombreSalon + nombreChambre
 
            // Gardés pour rétrocompat / vues détail (dérivés de nombrePieces)
            $table->integer('salleBain')->default(0);    // NOUVEAU
 
            /* ── Disponibilité ── */
            $table->date('disponible_date')->nullable();  // NOUVEAU
 
            /* ── Options résidentielles ── */
            $table->string('meuble')->default('Non meublé');
            $table->string('collocation')->default('Non'); // NOUVEAU
            $table->string('packing')->default('Non');     // parking
 
            /* ── Équipements ── */
            $table->string('clime')->default('Non');       // Climatiseur | Brasseur d'air | Non
            $table->string('wifi')->default('Non');        // Wifi | Fibre optique | Non
            $table->string('securite')->default('Non');    // Oui | Non
            $table->string('terasse')->default('Non');     // Oui | Non
            $table->string('cuisine')->default('Non');     // Oui | Non
            $table->string('entretien')->default('Non inclus');

            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('dislikes')->default(0);

            $table->float('surface_salon')->default(0);
            $table->float('surface_cuisine')->default(0);
            $table->float('surface_chambre')->default(0);
            $table->float('surface_sdb')->default(0);
            $table->float('surface_bureau')->default(0);
            $table->string('compteur_eau')->default('Non');
            $table->string('compteur_elec')->default('Non');
            $table->integer('nombreCuisine')->default(0);
 
            /* ── Prix ── */
            $table->float('prix');
            $table->string('negociable')->default('Non');
            $table->string('caution')->default('0');       // string car "3 Mois", "A Negocier"…
 
            /* ── Contenu ── */
            $table->text('description')->nullable();;
            $table->text('images')->nullable();
 
            /* ── Méta ── */
            $table->boolean('statut')->default(1);        // 1 = actif, 0 = inactif
            $table->unsignedBigInteger('views')->default(0);
            $table->string('transactionId')->nullable();
 
            /* ── Relations ── */
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')
                  ->references('id')
                  ->on('entreprises')
                  ->onDelete('cascade');
 
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
 