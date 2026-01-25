@extends('layouts.app')

@section('title', 'Modifier ' . $product->name)

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier le produit</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-4">
                
                <!-- Nom -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Nom du produit *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-gray-700 mb-1">Référence (SKU) *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-gray-700 mb-1">Catégorie *</label>
                    <select name="category_id" required class="w-full border rounded px-3 py-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fournisseur -->
                <div>
                    <label class="block text-gray-700 mb-1">Fournisseur</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Aucun --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix achat -->
                <div>
                    <label class="block text-gray-700 mb-1">Prix d'achat (DT) *</label>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" 
                           step="0.01" min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Prix vente -->
                <div>
                    <label class="block text-gray-700 mb-1">Prix de vente (DT) *</label>
                    <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" 
                           step="0.01" min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Stock minimum -->
                <div>
                    <label class="block text-gray-700 mb-1">Stock minimum (alerte) *</label>
                    <input type="number" name="min_quantity" value="{{ old('min_quantity', $product->min_quantity) }}" 
                           min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Quantité actuelle (lecture seule) -->
                <div>
                    <label class="block text-gray-700 mb-1">Quantité actuelle</label>
                    <input type="text" value="{{ $product->quantity }}" disabled
                           class="w-full border rounded px-3 py-2 bg-gray-100">
                    <p class="text-xs text-gray-500 mt-1">Utilisez les mouvements de stock pour modifier</p>
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
