<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appartements', function (Blueprint $table) {

            // Surface habitable en m²
            $table->float('surface')->nullable()->after('commune');

            // Nombre de pièces total (remplace salon + chambre dans le formulaire)
            $table->integer('nombrePieces')->default(1)->after('surface');

            // Salle de bain
            $table->integer('salleBain')->default(0)->after('nombrePieces');

            // Disponibilité
            $table->date('disponible_date')->nullable()->after('salleBain');
            $table->boolean('dispo_immed')->default(0)->after('disponible_date');

            // Colocation
            $table->string('collocation')->default('Non')->after('meuble');
            
            // Colocation
            $table->string('collocation')->default('Non')->after('meuble');
            
            // Colocation
            $table->string('collocation')->default('Non')->after('meuble');
            
            // Colocation
            $table->string('collocation')->default('Non')->after('meuble');
                        
        });
    }

    public function down(): void
    {
        Schema::table('appartements', function (Blueprint $table) {
            $table->dropColumn([
                'surface',
                'nombrePieces',
                'salleBain',
                'disponible_date',
                'dispo_immed',
                'collocation',
                'transactionId',
            ]);
        });
    }
};