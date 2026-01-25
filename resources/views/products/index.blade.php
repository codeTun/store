@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Produits</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            + Nouveau produit
        </a>
    </div>

    <!-- Recherche en temps réel -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Rechercher un produit..."
               class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <!-- Tableau des produits -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition product-row">
                        <td class="px-6 py-4">
                            <a href="{{ route('products.show', $product) }}" class="font-medium text-gray-900 hover:text-blue-600 product-name">
                                {{ $product->name }}
                            </a>
                            <div class="text-sm text-gray-400 product-sku">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 product-category">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->quantity <= $product->min_quantity)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    {{ $product->quantity }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $product->quantity }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-medium text-gray-900">
                            {{ number_format($product->selling_price, 2, ',', ' ') }} DT
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Modifier
                                </a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-gray-400 mb-2">Aucun produit trouvé</div>
                            <a href="{{ route('products.create') }}" class="text-blue-500 hover:underline text-sm">
                                Créer un premier produit
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Script de recherche en temps réel -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.product-row');
            
            rows.forEach(function(row) {
                const name = row.querySelector('.product-name')?.textContent.toLowerCase() || '';
                const sku = row.querySelector('.product-sku')?.textContent.toLowerCase() || '';
                const category = row.querySelector('.product-category')?.textContent.toLowerCase() || '';
                
                if (name.includes(searchText) || sku.includes(searchText) || category.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
