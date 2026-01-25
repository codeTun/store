{{-- Barre supérieure avec recherche et actions rapides --}}
{{-- Design moderne et épuré --}}

<header class="h-16 bg-slate-900/50 border-b border-slate-800/50 backdrop-blur-xl flex items-center justify-between px-6">
    {{-- Bouton menu mobile --}}
    <button class="lg:hidden p-2 text-slate-400 hover:text-white transition-colors" onclick="toggleMobileMenu()">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- Barre de recherche globale --}}
    <div class="hidden md:flex items-center flex-1 max-w-xl">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   placeholder="Rechercher un produit, SKU, fournisseur..." 
                   class="w-full pl-12 pr-4 py-2.5 bg-slate-800/50 border border-slate-700/50 rounded-xl text-sm text-slate-300 placeholder-slate-500 focus:outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/50 transition-all"
                   id="global-search">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <kbd class="px-2 py-1 text-xs text-slate-500 bg-slate-700/50 rounded">⌘K</kbd>
            </div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="flex items-center gap-3">
        {{-- Bouton d'ajout rapide --}}
        <div class="relative" x-data="{ open: false }">
            <button onclick="toggleQuickAdd()" 
                    class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium text-sm transition-all shadow-lg shadow-emerald-500/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Ajouter</span>
            </button>
            {{-- Menu déroulant --}}
            <div id="quick-add-menu" class="hidden absolute right-0 mt-2 w-48 py-2 glass rounded-xl shadow-2xl z-50">
                <a href="{{ route('products.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 transition-colors">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Nouveau produit
                </a>
                <a href="{{ route('categories.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 transition-colors">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Nouvelle catégorie
                </a>
                <a href="{{ route('suppliers.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 transition-colors">
                    <svg class="w-4 h-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Nouveau fournisseur
                </a>
                <hr class="my-2 border-slate-700/50">
                <a href="{{ route('stock-movements.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 transition-colors">
                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    Mouvement de stock
                </a>
            </div>
        </div>

        {{-- Notifications --}}
        <button class="relative p-2.5 text-slate-400 hover:text-white bg-slate-800/50 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @php $alertCount = \App\Models\Product::active()->lowStock()->count(); @endphp
            @if($alertCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs text-white flex items-center justify-center font-bold badge-pulse">
                    {{ $alertCount > 9 ? '9+' : $alertCount }}
                </span>
            @endif
        </button>

        {{-- Profil (mobile) --}}
        <a href="{{ route('profile.edit') }}" class="lg:hidden p-2.5 text-slate-400 hover:text-white bg-slate-800/50 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
    </div>
</header>

{{-- Menu mobile --}}
<div id="mobile-menu" class="hidden lg:hidden fixed inset-0 z-50">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
    <div class="fixed inset-y-0 left-0 w-72 bg-slate-900 shadow-2xl transform transition-transform">
        @include('layouts.sidebar')
    </div>
</div>

<script>
    function toggleQuickAdd() {
        const menu = document.getElementById('quick-add-menu');
        menu.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Fermer le menu quick-add si on clique ailleurs
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('quick-add-menu');
        const button = e.target.closest('button');
        if (!button || !button.onclick?.toString().includes('toggleQuickAdd')) {
            if (!e.target.closest('#quick-add-menu')) {
                menu?.classList.add('hidden');
            }
        }
    });

    // Raccourci clavier pour la recherche
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('global-search')?.focus();
        }
    });
</script>

