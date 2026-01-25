@extends('layouts.app')

@section('title', 'Modifier fournisseur')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier le fournisseur</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nom *</label>
                <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Adresse</label>
                <textarea name="address" rows="2" class="w-full border rounded px-3 py-2">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
