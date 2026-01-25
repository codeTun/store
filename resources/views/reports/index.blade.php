@extends('layouts.app')

@section('title', 'Rapports')

@section('header')
    <div>
        <h1 class="text-2xl font-bold text-white">Rapports et Statistiques</h1>
        <p class="text-slate-400 mt-1">Analysez les performances de votre inventaire</p>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Rapport État du Stock --}}
        <a href="{{ route('reports.stock-status') }}" class="glass rounded-2xl p-6 card-hover group">
            <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-emerald-400 transition-colors">État du Stock</h3>
            <p class="text-sm text-slate-400">Valorisation du stock, alertes de niveau bas, répartition par catégorie.</p>
        </a>

        {{-- Rapport Mouvements --}}
        <a href="{{ route('reports.movements') }}" class="glass rounded-2xl p-6 card-hover group">
            <div class="w-14 h-14 bg-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-cyan-400 transition-colors">Mouvements de Stock</h3>
            <p class="text-sm text-slate-400">Analyse des entrées et sorties, évolution journalière, produits les plus actifs.</p>
        </a>

        {{-- Rapport Fournisseurs --}}
        <a href="{{ route('reports.suppliers') }}" class="glass rounded-2xl p-6 card-hover group">
            <div class="w-14 h-14 bg-violet-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-violet-400 transition-colors">Fournisseurs</h3>
            <p class="text-sm text-slate-400">Performance des fournisseurs, valeur des achats, nombre de produits.</p>
        </a>
    </div>

    {{-- Export de données --}}
    <div class="mt-8 glass rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Exporter les données
        </h2>
        <p class="text-slate-400 mb-6">Téléchargez vos données au format CSV pour les analyser dans Excel ou autre.</p>
        
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('reports.export', 'products') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Export Produits
            </a>
            <a href="{{ route('reports.export', 'movements') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Export Mouvements
            </a>
            <a href="{{ route('reports.export', 'low-stock') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Export Stock Faible
            </a>
        </div>
    </div>
@endsection

