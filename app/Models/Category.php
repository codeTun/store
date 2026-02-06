<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant une catégorie de produits.
 * 
 * Les catégories permettent d'organiser les produits de manière logique.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs qu'on peut remplir en masse.
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relation vers les produits de cette catégorie.
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
