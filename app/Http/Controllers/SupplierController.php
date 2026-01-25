<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

/*
    Contrôleur des Fournisseurs
    
    Les fournisseurs sont les entreprises qui nous vendent les produits.
    On garde leurs coordonnées pour les contacter facilement.
*/
class SupplierController extends Controller
{
    // Liste des fournisseurs
    public function index()
    {
        $suppliers = Supplier::withCount('products')
            ->orderBy('name')
            ->paginate(15);
            
        return view('suppliers.index', compact('suppliers'));
    }

    // Formulaire de création
    public function create()
    {
        return view('suppliers.create');
    }

    // Enregistrer un fournisseur
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Supplier::create($data);

        return redirect()->route('suppliers.index')
            ->with('success', 'Fournisseur ajouté !');
    }

    // Afficher un fournisseur
    public function show(Supplier $supplier)
    {
        $supplier->load('products');
        return view('suppliers.show', compact('supplier'));
    }

    // Formulaire de modification
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    // Mettre à jour
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $supplier->update($data);

        return redirect()->route('suppliers.index')
            ->with('success', 'Fournisseur modifié !');
    }

    // Supprimer
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Fournisseur supprimé !');
    }
}
