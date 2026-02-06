<?php

/**
 * Migration pour créer la table des fournisseurs.
 * 
 * Les fournisseurs sont les entreprises ou personnes qui nous approvisionnent
 * en produits. On garde leurs coordonnées essentielles pour faciliter la communication.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table suppliers avec les informations de contact essentielles.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            
            // Nom de l'entreprise ou du fournisseur
            $table->string('name');
            
            // Adresse email principale
            $table->string('email')->unique();
            
            // Numéro de téléphone
            $table->string('phone')->nullable();
            
            // Adresse postale
            $table->text('address')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
