<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

/*
    Contrôleur des Produits
    
    Gère tout ce qui concerne les produits :
    - Afficher la liste
    - Créer un nouveau produit
    - Modifier un produit
    - Supprimer un produit
*/
class ProductController extends Controller
{
    // Affiche la liste des produits
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Recherche par nom si demandé
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('name')->paginate(15);
        
        return view('products.index', compact('products'));
    }

    // Formulaire de création
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        
        return view('products.create', compact('categories', 'suppliers'));
    }

    // Enregistrer un nouveau produit
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    // Afficher un produit
    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stockMovements' => function($q) {
            $q->latest()->take(10);
        }]);
        
        return view('products.show', compact('product'));
    }

    // Formulaire de modification
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    // Mettre à jour un produit
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produit modifié avec succès !');
    }

    // Supprimer un produit
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produit supprimé !');
    }
}
