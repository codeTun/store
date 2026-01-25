@extends('layouts.app')

@section('title', 'Nouveau mouvement de stock')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('stock-movements.index') }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Nouveau mouvement de stock</h1>
            <p class="text-slate-400 mt-1">Enregistrez une entrée, sortie ou ajustement de stock</p>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('stock-movements.store') }}" method="POST" class="max-w-2xl">
        @csrf

        <div class="glass rounded-2xl p-6 space-y-6">
            {{-- Type de mouvement --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-3">
                    Type de mouvement <span class="text-red-400">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @php
                        $typeIcons = [
                            'entry' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />',
                            'exit' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />',
                            'adjustment' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />',
                            'return' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />',
                            'loss' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />',
                        ];
                        $typeColors = [
                            'entry' => 'emerald',
                            'exit' => 'red',
                            'adjustment' => 'blue',
                            'return' => 'amber',
                            'loss' => 'rose',
                        ];
                    @endphp
                    @foreach($movementTypes as $key => $label)
                        @if($key !== 'transfer')
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="{{ $key }}" class="peer hidden" {{ old('type', 'entry') === $key ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl border-2 border-slate-700 peer-checked:border-{{ $typeColors[$key] ?? 'slate' }}-500 peer-checked:bg-{{ $typeColors[$key] ?? 'slate' }}-500/10 transition-all text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-{{ $typeColors[$key] ?? 'slate' }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $typeIcons[$key] ?? '' !!}
                                </svg>
                                <span class="text-sm font-medium text-slate-300">{{ $label }}</span>
                            </div>
                        </label>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Produit --}}
            <div>
                <label for="product_id" class="block text-sm font-medium text-slate-300 mb-2">
                    Produit <span class="text-red-400">*</span>
                </label>
                <select name="product_id" id="product_id" required
                        class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50 @error('product_id') border-red-500 @enderror">
                    <option value="">Sélectionnez un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" 
                                {{ old('product_id', $selectedProduct?->id) == $product->id ? 'selected' : '' }}
                                data-stock="{{ $product->quantity }}">
                            {{ $product->name }} (Stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
                
                {{-- Info stock actuel --}}
                <div id="current-stock-info" class="mt-2 p-3 bg-slate-800/30 rounded-lg hidden">
                    <span class="text-sm text-slate-400">Stock actuel : </span>
                    <span id="current-stock" class="font-mono font-bold text-white">0</span>
                </div>
            </div>

            {{-- Quantité --}}
            <div>
                <label for="quantity" class="block text-sm font-medium text-slate-300 mb-2">
                    Quantité <span class="text-red-400">*</span>
                </label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1"
                       class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 font-mono focus:outline-none focus:border-emerald-500/50 @error('quantity') border-red-500 @enderror">
                @error('quantity')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prix unitaire (optionnel) --}}
            <div>
                <label for="unit_price" class="block text-sm font-medium text-slate-300 mb-2">
                    Prix unitaire (€)
                </label>
                <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" step="0.01" min="0"
                       class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 font-mono focus:outline-none focus:border-emerald-500/50"
                       placeholder="Optionnel - utilise le prix du produit par défaut">
            </div>

            {{-- Référence --}}
            <div>
                <label for="reference" class="block text-sm font-medium text-slate-300 mb-2">
                    Référence externe
                </label>
                <input type="text" name="reference" id="reference" value="{{ old('reference') }}"
                       class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50"
                       placeholder="N° commande, n° facture, etc.">
            </div>

            {{-- Motif --}}
            <div>
                <label for="reason" class="block text-sm font-medium text-slate-300 mb-2">
                    Motif / Commentaire
                </label>
                <textarea name="reason" id="reason" rows="2"
                          class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 focus:outline-none focus:border-emerald-500/50 resize-none"
                          placeholder="Expliquez la raison de ce mouvement...">{{ old('reason') }}</textarea>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3 mt-6">
            <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Enregistrer le mouvement
            </button>
            <a href="{{ route('stock-movements.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-medium transition-all">
                Annuler
            </a>
        </div>
    </form>

    <script>
        // Afficher le stock actuel lors de la sélection d'un produit
        document.getElementById('product_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const stock = option.dataset.stock;
            const stockInfo = document.getElementById('current-stock-info');
            const stockValue = document.getElementById('current-stock');
            
            if (stock !== undefined && this.value) {
                stockValue.textContent = stock;
                stockInfo.classList.remove('hidden');
            } else {
                stockInfo.classList.add('hidden');
            }
        });

        // Déclencher l'événement au chargement si un produit est déjà sélectionné
        if (document.getElementById('product_id').value) {
            document.getElementById('product_id').dispatchEvent(new Event('change'));
        }
    </script>
@endsection

