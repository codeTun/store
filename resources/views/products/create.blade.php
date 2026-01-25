@extends('layouts.app')

@section('title', 'Nouveau produit')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Nouveau produit</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                
                <!-- Nom -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Nom du produit *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-gray-700 mb-1">Référence (SKU) *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required
                           class="w-full border rounded px-3 py-2 @error('sku') border-red-500 @enderror">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-gray-700 mb-1">Catégorie *</label>
                    <select name="category_id" required class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix achat -->
                <div>
                    <label class="block text-gray-700 mb-1">Prix d'achat (DT) *</label>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price', 0) }}" 
                           step="0.01" min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Prix vente -->
                <div>
                    <label class="block text-gray-700 mb-1">Prix de vente (DT) *</label>
                    <input type="number" name="selling_price" value="{{ old('selling_price', 0) }}" 
                           step="0.01" min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Quantité -->
                <div>
                    <label class="block text-gray-700 mb-1">Quantité en stock *</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}" 
                           min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Stock minimum -->
                <div>
                    <label class="block text-gray-700 mb-1">Stock minimum (alerte) *</label>
                    <input type="number" name="min_quantity" value="{{ old('min_quantity', 5) }}" 
                           min="0" required class="w-full border rounded px-3 py-2">
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Créer le produit
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
