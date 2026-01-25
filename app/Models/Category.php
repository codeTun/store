<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une catégorie de produits.
 * 
 * Les catégories permettent d'organiser les produits de manière logique.
 * Elles peuvent être hiérarchiques (une catégorie peut avoir une catégorie parente).
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs qu'on peut remplir en masse.
     * On protège ainsi contre les injections de données non désirées.
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'icon',
        'color',
    ];

    /**
     * Relation vers la catégorie parente.
     * Une catégorie peut optionnellement appartenir à une catégorie parente.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation vers les sous-catégories.
     * Une catégorie peut avoir plusieurs sous-catégories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relation vers les produits de cette catégorie.
     * Une catégorie contient plusieurs produits.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Récupère le nombre total de produits dans cette catégorie.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Récupère la valeur totale du stock de cette catégorie.
     */
    public function getTotalStockValueAttribute(): float
    {
        return $this->products()->sum(\DB::raw('quantity * selling_price'));
    }
}

