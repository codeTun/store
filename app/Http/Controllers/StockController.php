<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

/*
    Contrôleur des Mouvements de Stock
    
    Gère les entrées et sorties de stock.
    Quand on reçoit de la marchandise = entrée
    Quand on vend ou utilise = sortie
*/
class StockController extends Controller
{
    // Liste des mouvements
    public function index()
    {
        $movements = StockMovement::with('product')
            ->latest()
            ->paginate(20);
            
        return view('stock.index', compact('movements'));
    }

    // Formulaire pour créer un mouvement
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    // Enregistrer un mouvement
    public function store(Request $request)
    {
        // Validation des données
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entry,exit',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        // On récupère le produit
        $product = Product::findOrFail($data['product_id']);
        
        // Calcul de la nouvelle quantité
        $oldQuantity = $product->quantity;
        
        if ($data['type'] === 'entry') {
            // Entrée = on ajoute au stock
            $newQuantity = $oldQuantity + $data['quantity'];
            $quantityChange = $data['quantity'];
        } else {
            // Sortie = on retire du stock
            if ($oldQuantity < $data['quantity']) {
                return back()->with('error', 'Stock insuffisant !');
            }
            $newQuantity = $oldQuantity - $data['quantity'];
            $quantityChange = -$data['quantity'];
        }

        // On met à jour le stock du produit
        $product->update(['quantity' => $newQuantity]);

        // On enregistre le mouvement dans l'historique
        StockMovement::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'type' => $data['type'],
            'quantity' => $quantityChange,
            'quantity_before' => $oldQuantity,
            'quantity_after' => $newQuantity,
            'reason' => $data['reason'],
            'moved_at' => now(),
        ]);

        $message = $data['type'] === 'entry' 
            ? 'Entrée de stock enregistrée !' 
            : 'Sortie de stock enregistrée !';

        return redirect()->route('stock.index')->with('success', $message);
    }
}

