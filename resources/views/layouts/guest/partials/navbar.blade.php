<!-- Navigation -->
<nav :class="scrolled ? 'bg-white shadow-lg' : 'bg-white/95 backdrop-blur-md'" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl opacity-20 group-hover:opacity-30 transition-opacity duration-300 blur-sm"></div>
                        <div class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">CASH OUT</span>
                        <p class="text-xs text-gray-600 font-medium">Investissez en toute sécurité</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:gap-8">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors duration-200">
                    Accueil
                </a>
                <a href="{{ route('home') }}#features" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors duration-200">
                    Fonctionnalités
                </a>
                <a href="{{ route('home') }}#how-it-works" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors duration-200">
                    Comment ça marche
                </a>
                <a href="{{ route('home') }}#pricing" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors duration-200">
                    Tarifs
                </a>
                {{-- <a href="{{ route('home') }}#faq" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition-colors duration-200">
                    FAQ
                </a> --}}
            </div>

            <!-- Auth Buttons Desktop -->
            <div class="hidden lg:flex lg:items-center lg:gap-4">
                @auth
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary mr-2">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Commencer
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="h-6 w-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="lg:hidden border-t border-gray-200 bg-white"
         style="display: none;">
        <div class="space-y-1 px-4 pb-3 pt-2">
            <a href="{{ route('home') }}" 
               class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-colors duration-200"
               @click="mobileMenuOpen = false">
                Accueil
            </a>
            <a href="{{ route('home') }}#features" 
               class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-colors duration-200"
               @click="mobileMenuOpen = false">
                Fonctionnalités
            </a>
            <a href="{{ route('home') }}#how-it-works" 
               class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-colors duration-200"
               @click="mobileMenuOpen = false">
                Comment ça marche
            </a>
            <a href="{{ route('home') }}#pricing" 
               class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-colors duration-200"
               @click="mobileMenuOpen = false">
                Tarifs
            </a>
            <a href="{{ route('home') }}#faq" 
               class="block rounded-lg px-3 py-2 text-base font-semibold text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-colors duration-200"
               @click="mobileMenuOpen = false">
                FAQ
            </a>
        </div>
        <div class="border-t border-gray-200 px-4 py-3 space-y-2">
            @auth
                <a href="{{ route('user.dashboard') }}" 
                   class="btn btn-primary w-full justify-center"
                   @click="mobileMenuOpen = false">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="btn btn-secondary w-full justify-center"
                   @click="mobileMenuOpen = false">
                    Connexion
                </a>
                <a href="{{ route('register') }}" 
                   class="btn btn-primary w-full justify-center"
                   @click="mobileMenuOpen = false">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Commencer
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-20"></div>