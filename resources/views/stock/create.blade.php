@extends('layouts.app')

@section('title', 'Nouveau mouvement')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Nouveau mouvement de stock</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            
            <!-- Produit -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Produit *</label>
                <select name="product_id" required class="w-full border rounded px-3 py-2">
                    <option value="">-- Choisir un produit --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Type de mouvement -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Type de mouvement *</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="type" value="entry" checked class="mr-2">
                        <span class="text-green-600">Entrée (réception)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="exit" class="mr-2">
                        <span class="text-red-600">Sortie (vente)</span>
                    </label>
                </div>
            </div>

            <!-- Quantité -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Quantité *</label>
                <input type="number" name="quantity" value="1" min="1" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <!-- Raison -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Raison / Commentaire</label>
                <input type="text" name="reason" placeholder="Ex: Commande client #123"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('stock.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
