@extends('layouts.app')

@section('title', 'Fournisseurs')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Fournisseurs</h1>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            + Nouveau fournisseur
        </a>
    </div>

    <!-- Recherche en temps réel -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Rechercher un fournisseur..."
               class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fournisseur</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Produits</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-50 transition supplier-row">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900 supplier-name">{{ $supplier->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="supplier-email">
                                <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:underline text-sm">
                                    {{ $supplier->email }}
                                </a>
                            </div>
                            @if($supplier->phone)
                                <div class="text-sm text-gray-400">{{ $supplier->phone }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $supplier->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('suppliers.edit', $supplier) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Modifier
                                </a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer ce fournisseur ?')">
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
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-gray-400 mb-2">Aucun fournisseur</div>
                            <a href="{{ route('suppliers.create') }}" class="text-blue-500 hover:underline text-sm">
                                Ajouter un premier fournisseur
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $suppliers->links() }}</div>

    <!-- Script de recherche en temps réel -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('.supplier-row');
            
            rows.forEach(function(row) {
                const name = row.querySelector('.supplier-name')?.textContent.toLowerCase() || '';
                const email = row.querySelector('.supplier-email')?.textContent.toLowerCase() || '';
                
                if (name.includes(searchText) || email.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
