<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Routes pour les visiteurs (non connectés)
Route::middleware('guest')->group(function () {
    // Page de connexion
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Traitement du formulaire de connexion
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Routes pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
