@extends('layouts.app')

@section('title', 'Rapport - Mouvements de Stock')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('reports.index') }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Mouvements de Stock</h1>
            <p class="text-slate-400 mt-1">Analyse des mouvements du {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</p>
        </div>
    </div>
@endsection

@section('content')
    {{-- Filtres de période --}}
    <div class="glass rounded-2xl p-4 mb-6">
        <form method="GET" action="{{ route('reports.movements') }}" class="flex flex-wrap items-center gap-4">
            <span class="text-slate-400">Période :</span>
            <input type="date" name="date_from" value="{{ $dateFrom }}"
                   class="px-4 py-2 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">
            <span class="text-slate-500">→</span>
            <input type="date" name="date_to" value="{{ $dateTo }}"
                   class="px-4 py-2 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50">
            <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-medium transition-colors">
                Appliquer
            </button>
        </form>
    </div>

    {{-- Résumé --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass rounded-2xl p-6 border-l-4 border-emerald-500">
            <p class="text-sm text-slate-400 mb-2">Entrées de stock</p>
            <p class="text-3xl font-bold text-emerald-400">+{{ number_format($summary['total_entries']) }}</p>
            <p class="text-sm text-slate-500 mt-1">unités reçues</p>
        </div>
        <div class="glass rounded-2xl p-6 border-l-4 border-red-500">
            <p class="text-sm text-slate-400 mb-2">Sorties de stock</p>
            <p class="text-3xl font-bold text-red-400">-{{ number_format($summary['total_exits']) }}</p>
            <p class="text-sm text-slate-500 mt-1">unités expédiées</p>
        </div>
        <div class="glass rounded-2xl p-6 border-l-4 border-blue-500">
            <p class="text-sm text-slate-400 mb-2">Ajustements</p>
            <p class="text-3xl font-bold text-blue-400">{{ number_format($summary['total_adjustments']) }}</p>
            <p class="text-sm text-slate-500 mt-1">corrections</p>
        </div>
        <div class="glass rounded-2xl p-6 border-l-4 border-rose-500">
            <p class="text-sm text-slate-400 mb-2">Pertes</p>
            <p class="text-3xl font-bold text-rose-400">-{{ number_format($summary['total_losses']) }}</p>
            <p class="text-sm text-slate-500 mt-1">unités perdues</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Mouvements par type --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-6">Répartition par type</h2>
            <div class="space-y-4">
                @php
                    $typeColors = [
                        'entry' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-400'],
                        'exit' => ['bg' => 'bg-red-500', 'text' => 'text-red-400'],
                        'adjustment' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-400'],
                        'return' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-400'],
                        'loss' => ['bg' => 'bg-rose-500', 'text' => 'text-rose-400'],
                    ];
                    $typeLabels = \App\Models\StockMovement::TYPES;
                @endphp
                @foreach($movementsByType as $type => $data)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="{{ $typeColors[$type]['text'] ?? 'text-slate-400' }}">{{ $typeLabels[$type] ?? $type }}</span>
                            <span class="text-slate-400">{{ $data->count }} mouvements ({{ number_format(abs($data->total_quantity)) }} unités)</span>
                        </div>
                        <div class="h-2 bg-slate-800 rounded-full overflow-hidden">
                            @php
                                $maxCount = $movementsByType->max('count') ?: 1;
                                $percentage = ($data->count / $maxCount) * 100;
                            @endphp
                            <div class="{{ $typeColors[$type]['bg'] ?? 'bg-slate-500' }} h-full rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Produits les plus actifs --}}
        <div class="glass rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-6">Produits les plus mouvementés</h2>
            @if($mostActiveProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($mostActiveProducts as $index => $product)
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 bg-slate-800 rounded-full flex items-center justify-center text-xs text-slate-400">
                                {{ $index + 1 }}
                            </span>
                            <a href="{{ route('products.show', $product) }}" class="flex-1 text-white hover:text-emerald-400 transition-colors truncate">
                                {{ $product->name }}
                            </a>
                            <span class="font-mono text-sm text-cyan-400">{{ $product->stock_movements_count }} mvts</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-slate-400 py-4">Aucun mouvement sur cette période</p>
            @endif
        </div>
    </div>

    {{-- Évolution journalière --}}
    <div class="glass rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-6">Évolution journalière</h2>
        @if($dailyMovements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                            <th class="pb-3 font-medium">Date</th>
                            <th class="pb-3 font-medium text-center text-emerald-400">Entrées</th>
                            <th class="pb-3 font-medium text-center text-red-400">Sorties</th>
                            <th class="pb-3 font-medium text-center text-blue-400">Ajustements</th>
                            <th class="pb-3 font-medium text-center">Solde net</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($dailyMovements as $date => $movements)
                            @php
                                $entries = $movements->where('type', 'entry')->sum('total');
                                $exits = abs($movements->where('type', 'exit')->sum('total'));
                                $adjustments = $movements->where('type', 'adjustment')->sum('total');
                                $returns = $movements->where('type', 'return')->sum('total');
                                $net = $entries + $returns + $adjustments - $exits;
                            @endphp
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 text-slate-300">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                                <td class="py-3 text-center font-mono {{ $entries > 0 ? 'text-emerald-400' : 'text-slate-500' }}">
                                    {{ $entries > 0 ? '+' . $entries : '-' }}
                                </td>
                                <td class="py-3 text-center font-mono {{ $exits > 0 ? 'text-red-400' : 'text-slate-500' }}">
                                    {{ $exits > 0 ? '-' . $exits : '-' }}
                                </td>
                                <td class="py-3 text-center font-mono {{ $adjustments != 0 ? 'text-blue-400' : 'text-slate-500' }}">
                                    {{ $adjustments != 0 ? ($adjustments > 0 ? '+' : '') . $adjustments : '-' }}
                                </td>
                                <td class="py-3 text-center font-mono font-bold {{ $net > 0 ? 'text-emerald-400' : ($net < 0 ? 'text-red-400' : 'text-slate-400') }}">
                                    {{ $net > 0 ? '+' : '' }}{{ $net }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-slate-400 py-8">Aucun mouvement sur cette période</p>
        @endif
    </div>
@endsection

