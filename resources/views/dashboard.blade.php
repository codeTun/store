@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
    
    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_products'] }}</div>
            <div class="text-gray-500">Produits</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_categories'] }}</div>
            <div class="text-gray-500">Catégories</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold text-teal-600">{{ $stats['total_suppliers'] }}</div>
            <div class="text-gray-500">Fournisseurs</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold {{ $stats['low_stock'] > 0 ? 'text-red-600' : 'text-gray-600' }}">
                {{ $stats['low_stock'] }}
            </div>
            <div class="text-gray-500">Stock faible</div>
        </div>
    </div>

    <!-- Statistiques financières -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-400">
            <div class="text-2xl font-bold text-red-600">{{ number_format($stats['total_cost'], 2, ',', ' ') }} DT</div>
            <div class="text-gray-500">Coût d'achat total</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-400">
            <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['stock_value'], 2, ',', ' ') }} DT</div>
            <div class="text-gray-500">Valeur de vente</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 {{ $stats['potential_profit'] >= 0 ? 'border-green-500' : 'border-red-500' }}">
            <div class="text-2xl font-bold {{ $stats['potential_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $stats['potential_profit'] >= 0 ? '+' : '' }}{{ number_format($stats['potential_profit'], 2, ',', ' ') }} DT
            </div>
            <div class="text-gray-500">Gain potentiel</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Alertes stock faible -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Alertes Stock Faible</h2>
            
            @if($lowStockProducts->count() > 0)
                <ul class="space-y-2">
                    @foreach($lowStockProducts as $product)
                        <li class="flex justify-between items-center py-2 border-b">
                            <span>{{ $product->name }}</span>
                            <span class="text-red-600 font-bold">{{ $product->quantity }} restants</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-green-600">Tous les stocks sont OK</p>
            @endif
        </div>

        <!-- Derniers mouvements -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Derniers Mouvements</h2>
            
            @if($recentMovements->count() > 0)
                <ul class="space-y-2">
                    @foreach($recentMovements as $movement)
                        <li class="flex justify-between items-center py-2 border-b">
                            <span>{{ $movement->product->name ?? 'Produit supprimé' }}</span>
                            <span class="{{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }} font-bold">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun mouvement récent</p>
            @endif
        </div>
    </div>
@endsection
