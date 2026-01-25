@extends('layouts.app')

@section('title', 'Nouvelle catégorie')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Nouvelle catégorie</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nom *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Créer
                </button>
                <a href="{{ route('categories.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
