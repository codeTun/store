@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Modifier
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Informations -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Informations</h2>
            
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Référence (SKU)</dt>
                    <dd class="font-mono">{{ $product->sku }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Catégorie</dt>
                    <dd>{{ $product->category->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Fournisseur</dt>
                    <dd>{{ $product->supplier->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Prix d'achat</dt>
                    <dd>{{ number_format($product->purchase_price, 2, ',', ' ') }} DT</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Prix de vente</dt>
                    <dd class="font-bold">{{ number_format($product->selling_price, 2, ',', ' ') }} DT</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Marge</dt>
                    <dd class="text-green-600 font-bold">{{ number_format($product->selling_price - $product->purchase_price, 2, ',', ' ') }} DT</dd>
                </div>
            </dl>

            @if($product->description)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-gray-500 text-sm">Description</p>
                    <p>{{ $product->description }}</p>
                </div>
            @endif
        </div>

        <!-- Stock -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Stock</h2>
            
            <div class="text-center py-4">
                <div class="text-5xl font-bold {{ $product->quantity <= $product->min_quantity ? 'text-red-600' : 'text-green-600' }}">
                    {{ $product->quantity }}
                </div>
                <p class="text-gray-500">unités en stock</p>
                <p class="text-sm text-gray-400 mt-2">Seuil d'alerte : {{ $product->min_quantity }}</p>
            </div>

            <div class="mt-4 pt-4 border-t">
                <a href="{{ route('stock.create') }}?product={{ $product->id }}" 
                   class="block w-full bg-green-500 text-white text-center px-4 py-2 rounded hover:bg-green-600">
                    Mouvement de stock
                </a>
            </div>
        </div>
    </div>

    <!-- Historique des mouvements -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-lg font-bold mb-4">Derniers mouvements</h2>
        
        @if($product->stockMovements->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-center">Type</th>
                        <th class="px-4 py-2 text-center">Quantité</th>
                        <th class="px-4 py-2 text-left">Raison</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->stockMovements as $movement)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($movement->type == 'entry')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Entrée</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Sortie</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center font-bold {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </td>
                            <td class="px-4 py-2 text-gray-500">{{ $movement->reason ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-center py-4">Aucun mouvement enregistré</p>
        @endif
    </div>
@endsection
