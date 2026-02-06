<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un fournisseur.
 * 
 * Les fournisseurs sont nos partenaires qui nous approvisionnent en produits.
 * On garde leurs coordonnées essentielles pour faciliter les commandes.
 */
class Supplier extends Model
{
    use HasFactory;

    /**
     * Les attributs qu'on peut remplir en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relation vers les produits fournis par ce fournisseur.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Récupère le nombre de produits fournis par ce fournisseur.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}
