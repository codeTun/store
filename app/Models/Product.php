<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un produit dans l'inventaire.
 * 
 * C'est l'entité centrale de notre système. Chaque produit a un SKU unique,
 * des informations de stock, de prix et est lié à une catégorie et un fournisseur.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Les attributs qu'on peut remplir en masse.
     */
    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'supplier_id',
        'purchase_price',
        'selling_price',
        'quantity',
        'min_quantity',
        'max_quantity',
        'unit',
        'location',
        'barcode',
        'image',
        'is_active',
        'notes',
    ];

    /**
     * Les attributs à convertir automatiquement.
     */
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'quantity' => 'integer',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relation vers la catégorie du produit.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation vers le fournisseur du produit.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relation vers les mouvements de stock de ce produit.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Vérifie si le stock est en dessous du seuil minimum.
     * Utile pour déclencher des alertes automatiques.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    /**
     * Vérifie si le produit est en rupture de stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Calcule la valeur totale du stock pour ce produit.
     */
    public function getStockValueAttribute(): float
    {
        return $this->quantity * $this->selling_price;
    }

    /**
     * Calcule la marge bénéficiaire en pourcentage.
     */
    public function getProfitMarginAttribute(): float
    {
        if ($this->purchase_price <= 0) {
            return 0;
        }
        
        return (($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100;
    }

    /**
     * Retourne le statut du stock sous forme de texte.
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }
        
        if ($this->isLowStock()) {
            return 'low_stock';
        }
        
        return 'in_stock';
    }

    /**
     * Scope pour filtrer les produits actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour filtrer les produits avec stock faible.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'min_quantity');
    }

    /**
     * Scope pour filtrer les produits en rupture.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Génère automatiquement un SKU unique si non fourni.
     */
    public static function generateSku(): string
    {
        $prefix = 'PRD';
        $timestamp = now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -4));
        
        return "{$prefix}-{$timestamp}-{$random}";
    }
}

