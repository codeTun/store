<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle représentant un fournisseur.
 * 
 * Les fournisseurs sont nos partenaires qui nous approvisionnent en produits.
 * On garde leurs coordonnées complètes pour faciliter les commandes.
 */
class Supplier extends Model
{
    use HasFactory;

    /**
     * Les attributs qu'on peut remplir en masse.
     */
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'website',
        'notes',
        'is_active',
    ];

    /**
     * Les attributs à convertir automatiquement.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation vers les produits fournis par ce fournisseur.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Récupère l'adresse complète formatée.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->postal_code,
            $this->city,
            $this->country,
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Récupère le nombre de produits fournis par ce fournisseur.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Scope pour filtrer uniquement les fournisseurs actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

