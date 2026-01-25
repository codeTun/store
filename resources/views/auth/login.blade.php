<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - StockMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        
        <!-- Logo -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-blue-600">StockMaster</h1>
            <p class="text-gray-500 mt-2">Connectez-vous pour accéder à votre inventaire</p>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                Se connecter
            </button>
        </form>

        <!-- Aide -->
        <div class="mt-6 p-4 bg-gray-50 rounded text-sm text-gray-600">
            <p class="font-bold mb-1">Compte de démonstration :</p>
            <p>Email : <code class="bg-gray-200 px-1 rounded">admin@admin.com</code></p>
            <p>Mot de passe : <code class="bg-gray-200 px-1 rounded">password</code></p>
        </div>
    </div>

</body>
</html>
