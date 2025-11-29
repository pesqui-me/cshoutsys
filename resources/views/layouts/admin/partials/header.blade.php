<!-- Header Admin - PRIME BLOCK -->
<header class="sticky top-0 z-30 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="flex items-center justify-between h-16 lg:h-20 px-4 lg:px-8">
        
        <!-- Left Section -->
        <div class="flex items-center gap-4 lg:gap-6">
            
            <!-- Mobile Menu Toggle -->
            <button 
                @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            >
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Breadcrumb (Desktop) -->
            <nav class="hidden lg:flex items-center gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-sky-600 dark:text-gray-400 dark:hover:text-sky-400 transition-colors">
                    Admin
                </a>
                @if(isset($breadcrumbs))
                    @foreach($breadcrumbs as $breadcrumb)
                        <span class="text-gray-400 dark:text-gray-600">›</span>
                        @if($loop->last)
                            <span class="text-gray-900 dark:text-white font-semibold">{{ $breadcrumb['label'] }}</span>
                        @else
                            <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-sky-600 dark:text-gray-400 dark:hover:text-sky-400 transition-colors">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <span class="text-gray-400 dark:text-gray-600">›</span>
                    <span class="text-gray-900 dark:text-white font-semibold">{{ $title ?? 'Dashboard' }}</span>
                @endif
            </nav>
            
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-2 lg:gap-4">
            
            <!-- Search Bar (Desktop) -->
            <div class="hidden lg:block relative" x-data="{ searchOpen: false }">
                <input 
                    type="text" 
                    placeholder="Rechercher..." 
                    class="w-64 xl:w-80 pl-4 pr-10 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                    @focus="searchOpen = true"
                    @blur="setTimeout(() => searchOpen = false, 200)"
                >
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-sky-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Quick Actions (Desktop) -->
            <div class="hidden xl:flex items-center gap-2">
                <button class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 transition-all flex items-center gap-2">
                    <span>📥</span>
                    <span>Exporter</span>
                </button>
                <button class="px-4 py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white rounded-xl text-sm font-semibold transition-all flex items-center gap-2 shadow-lg shadow-sky-500/30">
                    <span>➕</span>
                    <span>Nouveau</span>
                </button>
            </div>

            <!-- Dark Mode Toggle -->
            <button 
                @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                class="p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            >
                <svg x-show="!darkMode" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </button>

            <!-- Notifications -->
            <div class="relative" x-data="{ notifOpen: false }">
                <button 
                    @click="notifOpen = !notifOpen"
                    class="relative p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white dark:border-gray-800 shadow-lg">
                        {{ auth()->user()->unreadNotifications()->count() }}
                    </span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div 
                    x-show="notifOpen"
                    @click.away="notifOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                    style="display: none;"
                >
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900 dark:text-white">Notifications</h3>
                        <a href="{{ route('admin.notifications.index') }}" class="text-sm text-sky-600 hover:text-sky-700 font-semibold">
                            Voir tout →
                        </a>
                    </div>

                    <!-- Notifications List -->
                    <div class="max-h-96 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications()->limit(5)->get() as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}" 
                           class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 transition-colors">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white">
                                    {{ $notification->data['icon'] ?? '📬' }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                                        {{ $notification->data['message'] ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-8 text-center">
                            <div class="text-5xl mb-3">🔔</div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Aucune notification</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ userMenuOpen: false }">
                <button 
                    @click="userMenuOpen = !userMenuOpen"
                    class="flex items-center gap-3 pl-1 pr-3 py-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-black text-sm shadow-lg border-2 border-white dark:border-gray-800">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</p>
                    </div>
                </button>

                <!-- User Dropdown -->
                <div 
                    x-show="userMenuOpen"
                    @click.away="userMenuOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                    style="display: none;"
                >
                    <!-- User Info -->
                    <div class="p-4 bg-gradient-to-br from-sky-500 to-blue-600 text-white">
                        <p class="font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-sky-100 mt-0.5">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="p-2">
                        <a href="{{ route('admin.profile.edit') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg">👤</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mon Profil</span>
                        </a>
                        <a href="{{ route('admin.settings.security') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg">🔒</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sécurité</span>
                        </a>
                        <a href="{{ route('admin.help') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <span class="text-lg">❓</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Centre d'aide</span>
                        </a>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-red-600 dark:text-red-400">
                                <span class="text-lg">🚪</span>
                                <span class="text-sm font-medium">Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>