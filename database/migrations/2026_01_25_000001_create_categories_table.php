<?php

/**
 * Migration pour créer la table des catégories de produits.
 * 
 * Les catégories permettent d'organiser les produits de manière hiérarchique
 * et facilitent la navigation et le filtrage dans l'inventaire.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration pour créer la table categories.
     * On stocke le nom, la description et une référence parent optionnelle
     * pour permettre une hiérarchie de catégories (ex: Électronique > Smartphones).
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Nom de la catégorie - obligatoire et unique pour éviter les doublons
            $table->string('name')->unique();
            
            // Description optionnelle pour donner plus de contexte
            $table->text('description')->nullable();
            
            // Référence vers une catégorie parente (pour la hiérarchie)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
            
            // Icône de la catégorie (nom de classe Font Awesome ou autre)
            $table->string('icon')->nullable();
            
            // Couleur associée pour l'affichage visuel
            $table->string('color')->default('#6366f1');
            
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration - supprimer la table categories.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

