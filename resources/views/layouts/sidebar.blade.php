{{-- Sidebar de navigation principale --}}
{{-- Design moderne avec effet glassmorphism et icônes élégantes --}}

<aside class="hidden lg:flex lg:flex-col w-72 bg-slate-900/50 border-r border-slate-800/50 backdrop-blur-xl">
    {{-- Logo et nom de l'application --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800/50">
        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div>
            <h1 class="text-lg font-bold gradient-text">StockMaster</h1>
            <p class="text-xs text-slate-500">Gestion d'inventaire</p>
        </div>
    </div>

    {{-- Navigation principale --}}
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        {{-- Section principale --}}
        <p class="px-3 mb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Principal</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('dashboard') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </div>
            <span class="font-medium">Tableau de bord</span>
        </a>

        {{-- Section Inventaire --}}
        <p class="px-3 mt-6 mb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Inventaire</p>

        <a href="{{ route('products.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('products.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('products.*') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="font-medium">Produits</span>
            @php $lowStockCount = \App\Models\Product::active()->lowStock()->count(); @endphp
            @if($lowStockCount > 0)
                <span class="ml-auto px-2 py-0.5 text-xs font-bold bg-amber-500/20 text-amber-400 rounded-full badge-pulse">
                    {{ $lowStockCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('categories.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('categories.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('categories.*') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <span class="font-medium">Catégories</span>
        </a>

        <a href="{{ route('suppliers.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('suppliers.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('suppliers.*') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="font-medium">Fournisseurs</span>
        </a>

        {{-- Section Opérations --}}
        <p class="px-3 mt-6 mb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Opérations</p>

        <a href="{{ route('stock-movements.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('stock-movements.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('stock-movements.*') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
            </div>
            <span class="font-medium">Mouvements</span>
        </a>

        <a href="{{ route('stock-movements.create') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-slate-400 hover:text-white hover:bg-slate-800/50">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-slate-800 group-hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="font-medium">Nouveau mouvement</span>
        </a>

        {{-- Section Rapports --}}
        <p class="px-3 mt-6 mb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Analyses</p>

        <a href="{{ route('reports.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('reports.*') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                        {{ request()->routeIs('reports.*') ? 'bg-emerald-500/20' : 'bg-slate-800 group-hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <span class="font-medium">Rapports</span>
        </a>
    </nav>

    {{-- Footer avec infos utilisateur --}}
    <div class="p-4 border-t border-slate-800/50">
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-slate-800/30">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-400 transition-colors" title="Déconnexion">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

