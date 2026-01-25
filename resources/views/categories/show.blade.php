@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
        <a href="{{ route('categories.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
            Retour
        </a>
    </div>

    @if($category->description)
        <p class="text-gray-600 mb-6">{{ $category->description }}</p>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Produits dans cette catégorie ({{ $category->products->count() }})</h2>
        
        @if($category->products->count() > 0)
            <ul class="divide-y">
                @foreach($category->products as $product)
                    <li class="py-3 flex justify-between">
                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">
                            {{ $product->name }}
                        </a>
                        <span class="text-gray-500">Stock: {{ $product->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun produit dans cette catégorie</p>
        @endif
    </div>
@endsection
