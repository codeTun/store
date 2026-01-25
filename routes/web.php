<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

/*
    Routes de l'application StockMaster
    
    C'est ici qu'on définit toutes les URLs de notre application.
    Chaque route pointe vers un contrôleur qui gère la logique.
*/

// Page d'accueil = redirection vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Toutes ces routes nécessitent d'être connecté
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (page principale après connexion)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des produits (CRUD complet)
    Route::resource('products', ProductController::class);
    
    // Gestion des catégories
    Route::resource('categories', CategoryController::class);
    
    // Gestion des fournisseurs
    Route::resource('suppliers', SupplierController::class);
    
    // Mouvements de stock (entrées/sorties)
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
});

// Routes d'authentification (login, logout)
require __DIR__.'/auth.php';
