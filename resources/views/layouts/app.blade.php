<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockMaster - @yield('title', 'Gestion de Stock')</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Barre de navigation -->
    <nav class="bg-white shadow mb-6">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                StockMaster
            </a>
            
            <!-- Menu -->
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" 
                   class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}" 
                   class="{{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                    Produits
                </a>
                <a href="{{ route('categories.index') }}" 
                   class="{{ request()->routeIs('categories.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                    Catégories
                </a>
                <a href="{{ route('suppliers.index') }}" 
                   class="{{ request()->routeIs('suppliers.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                    Fournisseurs
                </a>
                <a href="{{ route('stock.index') }}" 
                   class="{{ request()->routeIs('stock.*') ? 'text-blue-600 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                    Stock
                </a>
                
                <!-- Déconnexion -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-6xl mx-auto px-4 pb-8">
        
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
