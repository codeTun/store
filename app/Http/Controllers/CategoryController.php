<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

/* Laravel Eloquent : 
    with()
    withCount()
/*
    Contrôleur des Catégories
    
    Les catégories servent à organiser les produits.
    Par exemple : Électronique, Vêtements, Alimentation...
*/
class CategoryController extends Controller
{
    // Liste des catégories
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(15);
            
        return view('categories.index', compact('categories'));
    }

    // Formulaire de création
    public function create()
    {
        return view('categories.create');
    }

    // Enregistrer une catégorie
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée !');
    }

    // Afficher une catégorie avec ses produits
    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    // Formulaire de modification
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Mettre à jour
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie modifiée !');
    }

    // Supprimer
    public function destroy(Category $category)
    {
        // On vérifie qu'il n'y a pas de produits
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : cette catégorie contient des produits.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée !');
    }
}
