@extends('layouts.app')

@section('title', 'Mouvements de stock')

@section('header')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Mouvements de stock</h1>
            <p class="text-slate-400 mt-1">Historique de tous les mouvements d'inventaire</p>
        </div>
        <a href="{{ route('stock-movements.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-all shadow-lg shadow-emerald-500/20">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouveau mouvement
        </a>
    </div>
@endsection

@section('content')
    {{-- Filtres --}}
    <div class="glass rounded-2xl p-4 mb-6">
        <form method="GET" action="{{ route('stock-movements.index') }}" class="flex flex-wrap gap-4">
            <select name="product" class="px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">
                <option value="">Tous les produits</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            <select name="type" class="px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">
                <option value="">Tous les types</option>
                @foreach($movementTypes as $key => $label)
                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">
            
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">

            <input type="text" name="reference" value="{{ request('reference') }}" placeholder="Référence..."
                   class="px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 placeholder-slate-500 focus:outline-none focus:border-emerald-500/50">

            <button type="submit" class="px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-sm font-medium transition-colors">
                Filtrer
            </button>
            @if(request()->hasAny(['product', 'type', 'date_from', 'date_to', 'reference']))
                <a href="{{ route('stock-movements.index') }}" class="px-4 py-2.5 text-slate-400 hover:text-white transition-colors">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    {{-- Liste des mouvements --}}
    <div class="glass rounded-2xl overflow-hidden">
        @if($movements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-800/50">
                        <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">Date</th>
                            <th class="px-6 py-4 font-medium">Produit</th>
                            <th class="px-6 py-4 font-medium">Type</th>
                            <th class="px-6 py-4 font-medium text-center">Quantité</th>
                            <th class="px-6 py-4 font-medium">Avant → Après</th>
                            <th class="px-6 py-4 font-medium">Référence</th>
                            <th class="px-6 py-4 font-medium">Par</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($movements as $movement)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-400 whitespace-nowrap">
                                    {{ $movement->moved_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $movement->product) }}" class="font-medium text-white hover:text-emerald-400 transition-colors">
                                        {{ $movement->product->name ?? 'Produit supprimé' }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $typeColors = [
                                            'entry' => 'bg-emerald-500/10 text-emerald-400',
                                            'exit' => 'bg-red-500/10 text-red-400',
                                            'adjustment' => 'bg-blue-500/10 text-blue-400',
                                            'return' => 'bg-amber-500/10 text-amber-400',
                                            'loss' => 'bg-rose-500/10 text-rose-400',
                                            'transfer' => 'bg-violet-500/10 text-violet-400',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs rounded-full {{ $typeColors[$movement->type] ?? 'bg-slate-700 text-slate-300' }}">
                                        {{ $movement->type_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono font-bold {{ $movement->quantity > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono text-sm text-slate-400">
                                    {{ $movement->quantity_before }} → <span class="text-white">{{ $movement->quantity_after }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $movement->reference ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $movement->user->name ?? 'Système' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-800">
                {{ $movements->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">Aucun mouvement</h3>
                <p class="text-slate-400 mb-6">Les mouvements de stock apparaîtront ici.</p>
                <a href="{{ route('stock-movements.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer un mouvement
                </a>
            </div>
        @endif
    </div>
@endsection

