@extends('layouts.app')

@section('title', 'Mouvements de stock')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mouvements de Stock</h1>
        <a href="{{ route('stock.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            + Nouveau mouvement
        </a>
    </div>

    <!-- Recherche en temps réel -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Rechercher par produit..."
               class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Raison</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50 transition movement-row">
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $movement->created_at->format('d/m/Y') }}
                            <div class="text-xs text-gray-400">{{ $movement->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 movement-product">
                            @if($movement->product)
                                <a href="{{ route('products.show', $movement->product) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $movement->product->name }}
                                </a>
                            @else
                                <span class="text-gray-400 italic">Produit supprimé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($movement->type == 'entry')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Entrée
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Sortie
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-lg {{ $movement->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 movement-reason">
                            {{ $movement->reason ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-gray-400 mb-2">Aucun mouvement enregistré</div>
                            <a href="{{ route('stock.create') }}" class="text-blue-500 hover:underline text-sm">
                                Créer un premier mouvement
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $movements->links() }}</div>

    <!-- Script de recherche en temps réel -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.movement-row');
            
            rows.forEach(function(row) {
                const product = row.querySelector('.movement-product')?.textContent.toLowerCase() || '';
                const reason = row.querySelector('.movement-reason')?.textContent.toLowerCase() || '';
                
                if (product.includes(searchText) || reason.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
