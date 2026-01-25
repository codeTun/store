@extends('layouts.app')

@section('title', 'Rapport - Fournisseurs')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('reports.index') }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Analyse des Fournisseurs</h1>
            <p class="text-slate-400 mt-1">Performance et répartition par fournisseur</p>
        </div>
    </div>
@endsection

@section('content')
    {{-- Statistiques globales --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Total fournisseurs</p>
            <p class="text-3xl font-bold text-white">{{ $totalStats['total_suppliers'] }}</p>
            <p class="text-sm text-emerald-400 mt-1">{{ $totalStats['active_suppliers'] }} actifs</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Valeur totale des achats</p>
            <p class="text-3xl font-bold text-cyan-400">{{ number_format($totalStats['total_purchase_value'], 2) }} €</p>
        </div>
        <div class="glass rounded-2xl p-6">
            <p class="text-sm text-slate-400 mb-2">Moyenne par fournisseur</p>
            <p class="text-3xl font-bold text-violet-400">
                {{ $totalStats['active_suppliers'] > 0 ? number_format($totalStats['total_purchase_value'] / $totalStats['active_suppliers'], 2) : 0 }} €
            </p>
        </div>
    </div>

    {{-- Liste des fournisseurs --}}
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-800/50">
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">#</th>
                        <th class="px-6 py-4 font-medium">Fournisseur</th>
                        <th class="px-6 py-4 font-medium text-center">Statut</th>
                        <th class="px-6 py-4 font-medium text-center">Produits</th>
                        <th class="px-6 py-4 font-medium text-center">Stock total</th>
                        <th class="px-6 py-4 font-medium text-right">Valeur achat</th>
                        <th class="px-6 py-4 font-medium text-right">Valeur vente</th>
                        <th class="px-6 py-4 font-medium text-right">Marge</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($suppliers as $index => $supplier)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('suppliers.show', $supplier['id']) }}" class="font-medium text-white hover:text-emerald-400 transition-colors">
                                    {{ $supplier['name'] }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($supplier['is_active'])
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-emerald-500/10 text-emerald-400 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-slate-700 text-slate-400 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-slate-500 rounded-full"></span>
                                        Inactif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-slate-300">{{ $supplier['products_count'] }}</td>
                            <td class="px-6 py-4 text-center font-mono text-slate-300">{{ number_format($supplier['total_stock']) }}</td>
                            <td class="px-6 py-4 text-right font-mono text-cyan-400">{{ number_format($supplier['total_purchase_value'], 2) }} €</td>
                            <td class="px-6 py-4 text-right font-mono text-white">{{ number_format($supplier['total_selling_value'], 2) }} €</td>
                            <td class="px-6 py-4 text-right">
                                @php
                                    $margin = $supplier['total_purchase_value'] > 0 
                                        ? (($supplier['total_selling_value'] - $supplier['total_purchase_value']) / $supplier['total_purchase_value']) * 100 
                                        : 0;
                                @endphp
                                <span class="font-mono {{ $margin > 0 ? 'text-emerald-400' : 'text-slate-400' }}">
                                    {{ $margin > 0 ? '+' : '' }}{{ number_format($margin, 1) }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                                Aucun fournisseur enregistré
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

