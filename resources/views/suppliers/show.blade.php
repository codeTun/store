@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $supplier->name }}</h1>
        <a href="{{ route('suppliers.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
            Retour
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Informations</h2>
            <dl class="space-y-2">
                <div><dt class="text-gray-500 inline">Email :</dt> <dd class="inline">{{ $supplier->email }}</dd></div>
                <div><dt class="text-gray-500 inline">Téléphone :</dt> <dd class="inline">{{ $supplier->phone ?? '-' }}</dd></div>
                <div><dt class="text-gray-500 inline">Adresse :</dt> <dd class="inline">{{ $supplier->address ?? '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Produits ({{ $supplier->products->count() }})</h2>
            @if($supplier->products->count() > 0)
                <ul class="divide-y">
                    @foreach($supplier->products as $product)
                        <li class="py-2">
                            <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">
                                {{ $product->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun produit</p>
            @endif
        </div>
    </div>
@endsection
