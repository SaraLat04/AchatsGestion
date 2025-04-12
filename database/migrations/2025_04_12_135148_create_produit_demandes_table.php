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
        Schema::create('produit_demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')  // Clé étrangère vers la table 'demandes'
                  ->constrained('demandes')  // Assure la contrainte avec la table 'demandes'
                  ->onDelete('cascade'); 
            $table->string('nom');
            $table->integer('quantite');  // Si une demande est supprimée, supprime également la ligne dans 'produit_demandes'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_demandes');
    }
};
