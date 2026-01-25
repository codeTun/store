@extends('layouts.app')

@section('title', 'Rapport - État du Stock')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('reports.index') }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">État du Stock</h1>
            <p class="text-slate-400 mt-1">Analyse détaillée de la valorisation et de l'état des stocks</p>
        </div>
    </div>
@endsection

@section('content')
    {{-- Statistiques globales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Total produits</p>
            <p class="text-3xl font-bold text-white">{{ number_format($stats['total_products']) }}</p>
            <p class="text-sm text-emerald-400 mt-1">{{ $stats['active_products'] }} actifs</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Valeur du stock (vente)</p>
            <p class="text-3xl font-bold text-emerald-400">{{ number_format($stats['total_stock_value'], 2) }} €</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Valeur du stock (achat)</p>
            <p class="text-3xl font-bold text-cyan-400">{{ number_format($stats['total_purchase_value'], 2) }} €</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Profit potentiel</p>
            <p class="text-3xl font-bold text-violet-400">{{ number_format($stats['potential_profit'], 2) }} €</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Alertes --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Alertes de stock
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-amber-500/10 rounded-xl border border-amber-500/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-xl">⚠️</span>
                        </div>
                        <div>
                            <p class="font-medium text-amber-200">Stock faible</p>
                            <p class="text-sm text-amber-300/70">Produits en dessous du seuil minimum</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-amber-400">{{ $stats['low_stock_count'] }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-red-500/10 rounded-xl border border-red-500/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <span class="text-xl">🚨</span>
                        </div>
                        <div>
                            <p class="font-medium text-red-200">Rupture de stock</p>
                            <p class="text-sm text-red-300/70">Produits avec stock à zéro</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-red-400">{{ $stats['out_of_stock_count'] }}</span>
                </div>
            </div>
        </div>

        {{-- Répartition par catégorie --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4">Valeur par catégorie</h2>
            <div class="space-y-3">
                @foreach($valueByCategory->take(6) as $cat)
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $cat['color'] }}"></div>
                        <span class="flex-1 text-sm text-slate-300 truncate">{{ $cat['name'] }}</span>
                        <span class="text-sm text-slate-400">{{ $cat['products_count'] }} prod.</span>
                        <span class="font-mono text-sm text-white">{{ number_format($cat['total_value'], 2) }} €</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Top produits par valeur --}}
    <div class="glass rounded-2xl p-6 mb-8">
        <h2 class="text-lg font-semibold text-white mb-6">Top 10 - Produits par valeur en stock</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                        <th class="pb-3 font-medium">#</th>
                        <th class="pb-3 font-medium">Produit</th>
                        <th class="pb-3 font-medium">Catégorie</th>
                        <th class="pb-3 font-medium text-center">Stock</th>
                        <th class="pb-3 font-medium text-right">Prix unitaire</th>
                        <th class="pb-3 font-medium text-right">Valeur totale</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($topValueProducts as $index => $product)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="py-3 text-slate-500">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <a href="{{ route('products.show', $product) }}" class="font-medium text-white hover:text-emerald-400 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $product->category->color }}20; color: {{ $product->category->color }}">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="py-3 text-center font-mono text-slate-300">{{ $product->quantity }}</td>
                            <td class="py-3 text-right font-mono text-slate-400">{{ number_format($product->selling_price, 2) }} €</td>
                            <td class="py-3 text-right font-mono text-emerald-400 font-bold">{{ number_format($product->stock_value, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Produits à réapprovisionner --}}
    @if($lowStockProducts->count() > 0)
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Produits à réapprovisionner ({{ $lowStockProducts->count() }})
                </h2>
                <a href="{{ route('reports.export', 'low-stock') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">
                    Exporter CSV →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Produit</th>
                            <th class="pb-3 font-medium">SKU</th>
                            <th class="pb-3 font-medium text-center">Stock actuel</th>
                            <th class="pb-3 font-medium text-center">Stock min</th>
                            <th class="pb-3 font-medium">Fournisseur</th>
                            <th class="pb-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($lowStockProducts as $product)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 font-medium text-white">{{ $product->name }}</td>
                                <td class="py-3 font-mono text-sm text-slate-400">{{ $product->sku }}</td>
                                <td class="py-3 text-center">
                                    <span class="font-mono font-bold {{ $product->quantity <= 0 ? 'text-red-400' : 'text-amber-400' }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td class="py-3 text-center font-mono text-slate-400">{{ $product->min_quantity }}</td>
                                <td class="py-3 text-slate-300">{{ $product->supplier?->name ?? '-' }}</td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('stock-movements.create', ['product' => $product->id]) }}" 
                                       class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">
                                        + Réappro
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

