@extends('layouts.app')

@section('title', 'Ajuster le stock - ' . $product->name)

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('products.show', $product) }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Ajuster le stock</h1>
            <p class="text-slate-400 mt-1">{{ $product->name }}</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-xl mx-auto">
        {{-- Info produit --}}
        <div class="glass rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-xl bg-slate-800 flex items-center justify-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-white">{{ $product->name }}</h3>
                    <p class="text-sm text-slate-400 font-mono">{{ $product->sku }}</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold {{ $product->isOutOfStock() ? 'text-red-400' : ($product->isLowStock() ? 'text-amber-400' : 'text-emerald-400') }}">
                        {{ $product->quantity }}
                    </p>
                    <p class="text-sm text-slate-400">en stock</p>
                </div>
            </div>
        </div>

        {{-- Formulaire d'ajustement --}}
        <form action="{{ route('stock-movements.process-quick-adjust', $product) }}" method="POST" class="glass rounded-2xl p-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="new_quantity" class="block text-sm font-medium text-slate-300 mb-2">
                        Nouvelle quantité en stock <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="new_quantity" id="new_quantity" 
                           value="{{ old('new_quantity', $product->quantity) }}" required min="0"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700/50 rounded-xl text-lg text-slate-300 font-mono text-center focus:outline-none focus:border-emerald-500/50"
                           oninput="updateDiff()">
                    
                    {{-- Différence calculée --}}
                    <div id="diff-info" class="mt-3 p-3 bg-slate-800/30 rounded-lg text-center">
                        <span class="text-slate-400">Différence : </span>
                        <span id="diff-value" class="font-mono font-bold">0</span>
                    </div>
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-slate-300 mb-2">
                        Motif de l'ajustement
                    </label>
                    <textarea name="reason" id="reason" rows="2"
                              class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50 resize-none"
                              placeholder="Ex: Inventaire physique, correction d'erreur...">{{ old('reason') }}</textarea>
                </div>

                {{-- Raccourcis --}}
                <div>
                    <p class="text-sm text-slate-500 mb-2">Raccourcis :</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="adjustBy(-10)" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm transition-colors">-10</button>
                        <button type="button" onclick="adjustBy(-5)" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm transition-colors">-5</button>
                        <button type="button" onclick="adjustBy(-1)" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm transition-colors">-1</button>
                        <button type="button" onclick="adjustBy(1)" class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 rounded-lg text-sm transition-colors">+1</button>
                        <button type="button" onclick="adjustBy(5)" class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 rounded-lg text-sm transition-colors">+5</button>
                        <button type="button" onclick="adjustBy(10)" class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 rounded-lg text-sm transition-colors">+10</button>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-all shadow-lg shadow-emerald-500/20">
                    Ajuster le stock
                </button>
                <a href="{{ route('products.show', $product) }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <script>
        const currentStock = {{ $product->quantity }};
        const input = document.getElementById('new_quantity');
        const diffValue = document.getElementById('diff-value');

        function updateDiff() {
            const newQty = parseInt(input.value) || 0;
            const diff = newQty - currentStock;
            
            if (diff > 0) {
                diffValue.textContent = '+' + diff;
                diffValue.className = 'font-mono font-bold text-emerald-400';
            } else if (diff < 0) {
                diffValue.textContent = diff;
                diffValue.className = 'font-mono font-bold text-red-400';
            } else {
                diffValue.textContent = '0';
                diffValue.className = 'font-mono font-bold text-slate-400';
            }
        }

        function adjustBy(amount) {
            const current = parseInt(input.value) || 0;
            const newValue = Math.max(0, current + amount);
            input.value = newValue;
            updateDiff();
        }

        updateDiff();
    </script>
@endsection

