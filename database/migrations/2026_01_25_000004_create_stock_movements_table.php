<?php

/**
 * Migration pour créer la table des mouvements de stock.
 * 
 * Cette table trace TOUS les mouvements de stock : entrées, sorties, ajustements.
 * C'est essentiel pour l'historique, les audits et comprendre l'évolution des stocks.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Créer la table stock_movements pour tracer chaque mouvement.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            
            // Produit concerné par ce mouvement
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Utilisateur qui a effectué ce mouvement
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            
            // Type de mouvement : entrée, sortie, ajustement, retour, etc.
            $table->enum('type', [
                'entry',      // Réception de marchandise
                'exit',       // Vente ou expédition
                'adjustment', // Correction d'inventaire
                'return',     // Retour client
                'transfer',   // Transfert entre emplacements
                'loss',       // Perte, vol, casse
            ]);
            
            // Quantité du mouvement (positive pour entrée, négative pour sortie)
            $table->integer('quantity');
            
            // Quantité en stock AVANT ce mouvement
            $table->integer('quantity_before');
            
            // Quantité en stock APRÈS ce mouvement
            $table->integer('quantity_after');
            
            // Prix unitaire au moment du mouvement (pour calculs de valorisation)
            $table->decimal('unit_price', 10, 2)->nullable();
            
            // Référence externe (n° commande, n° facture, etc.)
            $table->string('reference')->nullable();
            
            // Raison ou commentaire sur ce mouvement
            $table->text('reason')->nullable();
            
            // Date et heure précises du mouvement
            $table->timestamp('moved_at')->useCurrent();
            
            $table->timestamps();
            
            // Index pour les recherches fréquentes
            $table->index(['product_id', 'type']);
            $table->index('moved_at');
            $table->index('reference');
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};

