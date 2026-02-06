<?php

/**
 * Migration pour créer la table des produits.
 * 
 * C'est le cœur de notre système d'inventaire. Chaque produit a ses caractéristiques,
 * son stock, son prix et est relié à une catégorie et potentiellement un fournisseur.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table products avec les informations essentielles
     * pour gérer l'inventaire.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Référence unique du produit (SKU - Stock Keeping Unit)
            $table->string('sku')->unique();
            
            // Nom du produit - ce qu'on voit dans les listes
            $table->string('name');
            
            // Description détaillée du produit
            $table->text('description')->nullable();
            
            // Catégorie du produit - relation obligatoire
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Fournisseur principal du produit - optionnel
            $table->foreignId('supplier_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            
            // Prix d'achat (ce qu'on paie au fournisseur)
            $table->decimal('purchase_price', 10, 2)->default(0);
            
            // Prix de vente (ce qu'on facture aux clients)
            $table->decimal('selling_price', 10, 2)->default(0);
            
            // Quantité actuellement en stock
            $table->integer('quantity')->default(0);
            
            // Seuil d'alerte - on notifie quand le stock descend en dessous
            $table->integer('min_quantity')->default(5);
            
            $table->timestamps();
            
            // Index pour améliorer les performances de recherche
            $table->index(['name', 'sku']);
            $table->index('quantity');
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
