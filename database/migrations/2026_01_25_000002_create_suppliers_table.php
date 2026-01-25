<?php

/**
 * Migration pour créer la table des fournisseurs.
 * 
 * Les fournisseurs sont les entreprises ou personnes qui nous approvisionnent
 * en produits. On garde leurs coordonnées complètes pour faciliter la communication.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table suppliers avec toutes les informations de contact.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            
            // Nom de l'entreprise ou du fournisseur
            $table->string('name');
            
            // Nom de la personne de contact chez le fournisseur
            $table->string('contact_name')->nullable();
            
            // Adresse email principale
            $table->string('email')->unique();
            
            // Numéro de téléphone
            $table->string('phone')->nullable();
            
            // Adresse postale complète
            $table->text('address')->nullable();
            
            // Ville
            $table->string('city')->nullable();
            
            // Code postal
            $table->string('postal_code')->nullable();
            
            // Pays
            $table->string('country')->default('France');
            
            // Site web du fournisseur
            $table->string('website')->nullable();
            
            // Notes internes sur ce fournisseur (délais, qualité, etc.)
            $table->text('notes')->nullable();
            
            // Statut actif/inactif du fournisseur
            $table->boolean('is_active')->default(true);
            
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

