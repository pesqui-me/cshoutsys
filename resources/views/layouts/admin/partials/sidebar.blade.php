<!-- Sidebar Admin - PRIME BLOCK -->
<aside 
    x-show="sidebarOpen || window.innerWidth >= 1024"
    x-transition:enter="transition ease-out duration-200 lg:transition-none"
    x-transition:enter-start="opacity-0 -translate-x-full lg:opacity-100 lg:translate-x-0"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150 lg:transition-none"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 -translate-x-full"
    class="fixed left-0 top-0 bottom-0 w-72 bg-gradient-to-b from-slate-900 to-slate-950 shadow-2xl z-50 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-900"
    @resize.window="if (window.innerWidth >= 1024) sidebarOpen = false"
>
    <!-- Sidebar Header -->
    <div class="relative px-6 py-6 bg-gradient-to-br from-sky-500 to-blue-600 border-b border-white/10 overflow-hidden">
        <!-- Animated background -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.1)_0%,transparent_70%)] animate-pulse"></div>
        
        <div class="relative z-10 text-center">
            <div class="text-5xl mb-2 filter drop-shadow-lg">🛡️</div>
            <h1 class="text-2xl font-black font-poppins text-white tracking-wider drop-shadow-md">
                PRIME BLOCK
            </h1>
            <div class="inline-block mt-3 px-4 py-1.5 bg-gradient-to-r from-red-500 to-red-600 rounded-full text-white text-xs font-bold uppercase tracking-wider shadow-lg border border-white/20">
                Admin Panel
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="py-6 space-y-1">
        
        <!-- TABLEAU DE BORD Section -->
        <div class="px-6 mb-2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">📊 Tableau de bord</h3>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">📈</span>
            <span class="font-medium">Vue d'ensemble</span>
        </a>
        
        <a href="{{ route('admin.analytics') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.analytics') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">📊</span>
            <span class="font-medium">Analytiques</span>
        </a>

        <!-- Divider -->
        <div class="h-px mx-6 my-4 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <!-- GESTION Section -->
        <div class="px-6 mb-2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">👥 Gestion</h3>
        </div>
        
        <a href="{{ route('admin.users.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">👥</span>
            <span class="font-medium">Utilisateurs</span>
            @if(isset($stats['pending_users']) && $stats['pending_users'] > 0)
            <span class="ml-auto px-2.5 py-0.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-md">
                {{ $stats['pending_users'] }}
            </span>
            @endif
        </a>
        
        <a href="{{ route('admin.investments.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.investments.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">💎</span>
            <span class="font-medium">Investments</span>
            @if(isset($stats['active_investments']))
            <span class="ml-auto px-2.5 py-0.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full shadow-md">
                {{ $stats['active_investments'] }}
            </span>
            @endif
        </a>
        
        <a href="{{ route('admin.withdrawals.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.withdrawals.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">💰</span>
            <span class="font-medium">Retraits</span>
            @if(isset($stats['pending_withdrawals']) && $stats['pending_withdrawals'] > 0)
            <span class="ml-auto px-2.5 py-0.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-bold rounded-full shadow-md animate-pulse">
                {{ $stats['pending_withdrawals'] }}
            </span>
            @endif
        </a>
        
        <a href="{{ route('admin.transactions.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">💳</span>
            <span class="font-medium">Transactions</span>
        </a>

        <!-- Divider -->
        <div class="h-px mx-6 my-4 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <!-- CARTES & SUPPORT Section -->
        <div class="px-6 mb-2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">🎫 Cartes & Support</h3>
        </div>
        
        <a href="{{ route('admin.cards.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.cards.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">🃏</span>
            <span class="font-medium">Cartes Investment</span>
        </a>
        
        <a href="{{ route('admin.support.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.support.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">🎫</span>
            <span class="font-medium">Support Tickets</span>
            @if(isset($stats['open_tickets']) && $stats['open_tickets'] > 0)
            <span class="ml-auto px-2.5 py-0.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-md">
                {{ $stats['open_tickets'] }}
            </span>
            @endif
        </a>

        <!-- Divider -->
        <div class="h-px mx-6 my-4 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <!-- SYSTÈME Section -->
        <div class="px-6 mb-2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">⚙️ Système</h3>
        </div>
        
        <a href="{{ route('admin.settings.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">⚙️</span>
            <span class="font-medium">Paramètres</span>
        </a>
        
        <a href="{{ route('admin.logs.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.logs.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">📜</span>
            <span class="font-medium">Logs système</span>
        </a>
        
        <a href="{{ route('admin.notifications.index') }}" 
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-gradient-to-r from-sky-500/25 to-blue-500/20 text-white font-semibold shadow-md border-l-4 border-sky-500' : '' }}">
            <span class="text-2xl">🔔</span>
            <span class="font-medium">Notifications</span>
        </a>

        <!-- Divider -->
        <div class="h-px mx-6 my-4 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <!-- Quick Links -->
        <a href="{{ route('home') }}" target="_blank"
           class="group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-200">
            <span class="text-2xl">🌐</span>
            <span class="font-medium">Voir le site</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full group flex items-center gap-3 px-6 py-3 mx-3 rounded-lg text-gray-300 hover:bg-red-500/10 hover:text-red-400 transition-all duration-200">
                <span class="text-2xl">🚪</span>
                <span class="font-medium">Déconnexion</span>
            </button>
        </form>
    </nav>

    <!-- Sidebar Footer - Admin User Info -->
    <div class="sticky bottom-0 p-4 bg-black/20 border-t border-white/10 backdrop-blur-sm">
        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/10">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-black text-lg shadow-lg border-2 border-white/20">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-sky-400 font-semibold">
                    {{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}
                </p>
            </div>
        </div>
    </div>
</aside>