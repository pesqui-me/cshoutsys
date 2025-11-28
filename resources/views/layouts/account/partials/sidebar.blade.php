<!-- Sidebar pour desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center gap-x-3">
            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                CASH OUT
            </span>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('user.dashboard') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.dashboard') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Tableau de bord
                            </a>
                        </li>

                        <!-- Acheter une carte -->
                        <li>
                            <a href="{{ route('user.investments.buy-card') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.investments.buy-card') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.investments.buy-card') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Acheter une carte
                            </a>
                        </li>

                        <!-- Mes investissements -->
                        <li>
                            <a href="{{ route('user.investments.index') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.investments.*') && !request()->routeIs('user.investments.buy-card') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.investments.*') && !request()->routeIs('user.investments.buy-card') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                                Mes investissements
                            </a>
                        </li>

                        <!-- Retraits -->
                        <li>
                            <a href="{{ route('user.withdrawals.index') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.withdrawals.*') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.withdrawals.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Retraits
                            </a>
                        </li>

                        <!-- Historique -->
                        <li>
                            <a href="{{ route('user.transactions.index') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.transactions.*') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.transactions.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Historique
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">Paramètres</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <!-- Profil -->
                        <li>
                            <a href="{{ route('user.profile.home') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.profile.*') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.profile.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Profil
                            </a>
                        </li>

                        <!-- Support -->
                        <li>
                            <a href="{{ route('user.support.index') }}" 
                               class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.support.*') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.support.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Support
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Balance (sticky bottom) -->
                <li class="mt-auto">
                    <div class="rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 px-4 py-3 border border-primary-200">
                        <div class="text-xs font-medium text-primary-900 mb-1">Solde disponible</div>
                        <div class="text-2xl font-bold text-primary-600">
                            {{ number_format(auth()->user()->balance, 2, ',', ' ') }} $
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Sidebar mobile -->
<div x-show="sidebarOpen" 
     class="relative z-50 lg:hidden" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">
    <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen"
             @click.away="sidebarOpen = false"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative mr-16 flex w-full max-w-xs flex-1">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                <!-- Logo -->
                <div class="flex h-16 shrink-0 items-center gap-x-3">
                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-700 bg-clip-text text-transparent">
                        CASH OUT
                    </span>
                </div>

                <!-- Navigation (même contenu que desktop) -->
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <!-- Répéter la même navigation que desktop -->
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <!-- Dashboard -->
                                <li>
                                    <a href="{{ route('user.dashboard') }}" 
                                       @click="sidebarOpen = false"
                                       class="group flex gap-x-3 rounded-lg p-2.5 text-sm font-semibold leading-6 {{ request()->routeIs('user.dashboard') ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} transition-colors duration-200">
                                        <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('user.dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Tableau de bord
                                    </a>
                                </li>
                                <!-- Les autres items... (copier du desktop) -->
                            </ul>
                        </li>

                        <!-- Balance mobile -->
                        <li class="mt-auto">
                            <div class="rounded-lg bg-gradient-to-br from-primary-50 to-primary-100 px-4 py-3 border border-primary-200">
                                <div class="text-xs font-medium text-primary-900 mb-1">Solde disponible</div>
                                <div class="text-2xl font-bold text-primary-600">
                                    {{ number_format(auth()->user()->balance, 2, ',', ' ') }} $
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>