<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle représentant un mouvement de stock.
 * 
 * Chaque entrée, sortie ou ajustement de stock est enregistré ici.
 * Cela permet de garder un historique complet et de tracer toutes les opérations.
 */
class StockMovement extends Model
{
    use HasFactory;

    /**
     * Les types de mouvement possibles avec leurs labels français.
     */
    public const TYPES = [
        'entry' => 'Entrée de stock',
        'exit' => 'Sortie de stock',
        'adjustment' => 'Ajustement',
        'return' => 'Retour',
        'transfer' => 'Transfert',
        'loss' => 'Perte',
    ];

    /**
     * Les attributs qu'on peut remplir en masse.
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_price',
        'reference',
        'reason',
        'moved_at',
    ];

    /**
     * Les attributs à convertir automatiquement.
     */
    protected $casts = [
        'quantity' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'unit_price' => 'decimal:2',
        'moved_at' => 'datetime',
    ];

    /**
     * Relation vers le produit concerné.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation vers l'utilisateur qui a effectué le mouvement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne le label français du type de mouvement.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Vérifie si c'est un mouvement d'entrée (qui augmente le stock).
     */
    public function isIncoming(): bool
    {
        return in_array($this->type, ['entry', 'return']);
    }

    /**
     * Vérifie si c'est un mouvement de sortie (qui diminue le stock).
     */
    public function isOutgoing(): bool
    {
        return in_array($this->type, ['exit', 'loss']);
    }

    /**
     * Calcule la valeur totale de ce mouvement.
     */
    public function getTotalValueAttribute(): float
    {
        return abs($this->quantity) * ($this->unit_price ?? 0);
    }

    /**
     * Scope pour filtrer par type de mouvement.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour filtrer les mouvements d'une période.
     */
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('moved_at', [$start, $end]);
    }

    /**
     * Scope pour les mouvements récents (30 derniers jours par défaut).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('moved_at', '>=', now()->subDays($days));
    }
}

