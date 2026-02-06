@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tableau de bord</h1>
    
    <!-- Statistiques principales -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        
        <!-- Produits -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</div>
                    <div class="text-sm text-gray-500">Produits</div>
                </div>
            </div>
        </div>
        
        <!-- Catégories -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total_categories'] }}</div>
                    <div class="text-sm text-gray-500">Catégories</div>
                </div>
            </div>
        </div>
        
        <!-- Fournisseurs -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-teal-100 rounded-lg">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total_suppliers'] }}</div>
                    <div class="text-sm text-gray-500">Fournisseurs</div>
                </div>
            </div>
        </div>
        
        <!-- Stock faible -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="p-2 {{ $stats['low_stock'] > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-lg">
                    <svg class="w-6 h-6 {{ $stats['low_stock'] > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold {{ $stats['low_stock'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $stats['low_stock'] }}
                    </div>
                    <div class="text-sm text-gray-500">Stock faible</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques financières -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        
        <!-- Coût d'achat -->
        <div class="bg-gradient-to-r from-amber-50 to-white p-5 rounded-lg shadow-sm border border-amber-100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-100 rounded-full">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-bold text-amber-600">{{ number_format($stats['total_cost'], 2, ',', ' ') }} DT</div>
                    <div class="text-sm text-gray-500">Coût d'achat total</div>
                </div>
            </div>
        </div>
        
        <!-- Valeur de vente -->
        <div class="bg-gradient-to-r from-blue-50 to-white p-5 rounded-lg shadow-sm border border-blue-100">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-bold text-blue-600">{{ number_format($stats['stock_value'], 2, ',', ' ') }} DT</div>
                    <div class="text-sm text-gray-500">Valeur de vente</div>
                </div>
            </div>
        </div>
        
        <!-- Gain potentiel -->
        <div class="bg-gradient-to-r {{ $stats['potential_profit'] >= 0 ? 'from-green-50' : 'from-red-50' }} to-white p-5 rounded-lg shadow-sm border {{ $stats['potential_profit'] >= 0 ? 'border-green-100' : 'border-red-100' }}">
            <div class="flex items-center gap-3">
                <div class="p-2 {{ $stats['potential_profit'] >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-full">
                    <svg class="w-5 h-5 {{ $stats['potential_profit'] >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-bold {{ $stats['potential_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['potential_profit'] >= 0 ? '+' : '' }}{{ number_format($stats['potential_profit'], 2, ',', ' ') }} DT
                    </div>
                    <div class="text-sm text-gray-500">Gain potentiel</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Alertes stock faible -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Alertes Stock</h2>
            </div>
            
            @if($lowStockProducts->count() > 0)
                <ul class="space-y-2">
                    @foreach($lowStockProducts as $product)
                        <li class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-700">{{ $product->name }}</span>
                            <span class="text-red-500 font-medium text-sm bg-red-50 px-2 py-1 rounded">
                                {{ $product->quantity }} restants
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex items-center gap-2 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tous les stocks sont OK</span>
                </div>
            @endif
        </div>

        <!-- Derniers mouvements -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Derniers Mouvements</h2>
            </div>
            
            @if($recentMovements->count() > 0)
                <ul class="space-y-2">
                    @foreach($recentMovements as $movement)
                        <li class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-700">{{ $movement->product->name ?? 'Produit supprimé' }}</span>
                            <span class="{{ $movement->quantity > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} font-medium text-sm px-2 py-1 rounded">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-400">Aucun mouvement récent</p>
            @endif
        </div>
    </div>
@endsection
