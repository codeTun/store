<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockMovement;

/*
    Contrôleur du Dashboard
    
    C'est la page principale qu'on voit après la connexion.
    Elle affiche un résumé de l'inventaire.
*/
class DashboardController extends Controller
{
    public function index()
    {
        // Calcul du coût total d'achat (ce qu'on a payé)
        $totalCost = Product::sum(\DB::raw('quantity * purchase_price'));
        
        // Calcul de la valeur de vente (ce qu'on peut gagner)
        $totalSaleValue = Product::sum(\DB::raw('quantity * selling_price'));
        
        // Gain potentiel = valeur de vente - coût d'achat
        $potentialProfit = $totalSaleValue - $totalCost;

        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
            'stock_value' => $totalSaleValue,
            'total_cost' => $totalCost,
            'potential_profit' => $potentialProfit,
            'low_stock' => Product::whereColumn('quantity', '<=', 'min_quantity')->count(),
        ];

        // Produits avec stock faible
        $lowStockProducts = Product::with('category')
            ->whereColumn('quantity', '<=', 'min_quantity')
            ->orderBy('quantity')
            ->take(5)
            ->get();

        // Derniers mouvements de stock
        $recentMovements = StockMovement::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'lowStockProducts', 'recentMovements'));
    }
}
