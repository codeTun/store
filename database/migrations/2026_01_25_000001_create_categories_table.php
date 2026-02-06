<?php

/**
 * Migration pour créer la table des catégories de produits.
 * 
 * Les catégories permettent d'organiser les produits de manière logique
 * et facilitent la navigation dans l'inventaire.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table categories avec les informations essentielles.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Nom de la catégorie - obligatoire et unique
            $table->string('name')->unique();
            
            // Description optionnelle pour donner plus de contexte
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
