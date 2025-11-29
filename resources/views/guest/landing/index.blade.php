<x-guest-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-primary-50 pt-16 pb-32">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-primary-200 opacity-20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-primary-300 opacity-20 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-8 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 rounded-full bg-primary-100 px-4 py-2 mb-6">
                        <svg class="h-4 w-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-primary-700">Plateforme certifiée et sécurisée</span>
                    </div>
                    
                    <h1 class="text-5xl font-extrabold text-gray-900 sm:text-6xl lg:text-7xl mb-6 leading-tight">
                        Investissez intelligemment,
                        <span class="bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                            Profitez rapidement
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Faites fructifier votre capital avec des rendements garantis allant jusqu'à <strong class="text-primary-600">30% en 48h</strong>. Simple, sécurisé, rentable.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-12">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Commencer maintenant
                        </a>
                        <a href="#how-it-works" class="btn btn-secondary btn-lg">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voir comment ça marche
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">10K+</p>
                            <p class="text-sm text-gray-600">Investisseurs actifs</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">$5M+</p>
                            <p class="text-sm text-gray-600">Investis</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-primary-600">30%</p>
                            <p class="text-sm text-gray-600">ROI maximum</p>
                        </div>
                    </div>
                </div>

                <!-- Right Image/Illustration -->
                <div class="relative">
                    <div class="relative rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 p-8 shadow-2xl">
                        <!-- Mock Dashboard -->
                        <div class="rounded-xl bg-white p-6 shadow-lg">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900">Portfolio</h3>
                                <span class="badge badge-success">Actif</span>
                            </div>
                            <div class="mb-6 rounded-lg bg-gradient-to-r from-green-50 to-green-100 p-4">
                                <p class="text-sm text-green-800 mb-1">Solde total</p>
                                <p class="text-3xl font-bold text-green-600">$12,450.00</p>
                                <p class="text-xs text-green-700 mt-1">+15.3% ce mois</p>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Carte Premium</p>
                                            <p class="text-xs text-gray-500">ROI: 30%</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+$450</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Carte Standard</p>
                                            <p class="text-xs text-gray-500">ROI: 20%</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+$200</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Cards -->
                    <div class="absolute -top-6 -right-6 rounded-xl bg-white p-4 shadow-xl hidden lg:block">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">Profit crédité</span>
                        </div>
                        <p class="text-2xl font-bold text-green-600">+$350.00</p>
                    </div>
                    <div class="absolute -bottom-6 -left-6 rounded-xl bg-white p-4 shadow-xl hidden lg:block">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-sm font-semibold text-gray-900">Investissement actif</span>
                        </div>
                        <p class="text-xs text-gray-600">Temps restant: 24h 15m</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                    Pourquoi choisir <span class="text-primary-600">PRIME BLOCK</span> ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une plateforme conçue pour maximiser vos rendements en toute sécurité
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">100% Sécurisé</h3>
                        <p class="text-gray-600">Vos données et investissements sont protégés par un cryptage SSL 256 bits et une authentification à deux facteurs.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-green-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">ROI jusqu'à 30%</h3>
                        <p class="text-gray-600">Profitez de rendements attractifs en seulement 48 heures. Investissez et récupérez vos gains rapidement.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Retraits rapides</h3>
                        <p class="text-gray-600">Retirez vos gains en 24-48h ouvrables via plusieurs méthodes de paiement sécurisées.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Support 24/7</h3>
                        <p class="text-gray-600">Notre équipe est disponible à tout moment pour répondre à vos questions et vous accompagner.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Transparent</h3>
                        <p class="text-gray-600">Suivez vos investissements en temps réel. Aucun frais caché, tout est clair et transparent.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="group relative rounded-2xl border border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Programme de parrainage</h3>
                        <p class="text-gray-600">Gagnez 5% de commission sur les investissements de vos filleuls. Partagez et profitez.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="how-it-works" class="py-24 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                    Comment ça marche ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Investissez en quelques clics et profitez rapidement
                </p>
            </div>

            <div class="relative">
                <!-- Connection Line -->
                <div class="absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-primary-200 via-primary-400 to-primary-200 transform -translate-y-1/2 hidden lg:block"></div>

                <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Step 1 -->
                    <div class="relative text-center">
                        <div class="relative inline-flex mb-6">
                            <div class="absolute inset-0 bg-primary-200 rounded-full blur-xl opacity-50"></div>
                            <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-600 shadow-2xl ring-8 ring-white">
                                <span class="text-2xl font-bold text-white">1</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Inscrivez-vous</h3>
                        <p class="text-gray-600">Créez votre compte gratuitement en quelques secondes</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center">
                        <div class="relative inline-flex mb-6">
                            <div class="absolute inset-0 bg-primary-200 rounded-full blur-xl opacity-50"></div>
                            <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-600 shadow-2xl ring-8 ring-white">
                                <span class="text-2xl font-bold text-white">2</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Choisissez une carte</h3>
                        <p class="text-gray-600">Sélectionnez le montant et le ROI qui vous convient</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center">
                        <div class="relative inline-flex mb-6">
                            <div class="absolute inset-0 bg-primary-200 rounded-full blur-xl opacity-50"></div>
                            <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-600 shadow-2xl ring-8 ring-white">
                                <span class="text-2xl font-bold text-white">3</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Investissez</h3>
                        <p class="text-gray-600">Effectuez votre paiement via votre méthode préférée</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative text-center">
                        <div class="relative inline-flex mb-6">
                            <div class="absolute inset-0 bg-green-200 rounded-full blur-xl opacity-50"></div>
                            <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-green-600 shadow-2xl ring-8 ring-white">
                                <span class="text-2xl font-bold text-white">4</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Profitez</h3>
                        <p class="text-gray-600">Recevez vos gains automatiquement après 48h</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    Commencer maintenant
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                    Nos cartes d'investissement
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choisissez la carte adaptée à votre budget et vos objectifs
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Bronze -->
                <div class="rounded-2xl border-2 border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Bronze</h3>
                        <p class="text-gray-600">Pour commencer</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-5xl font-extrabold text-gray-900">$50</span>
                        <span class="text-gray-600 ml-2">- $499</span>
                    </div>
                    <div class="mb-6 rounded-lg bg-blue-50 p-4">
                        <p class="text-sm text-blue-900 font-semibold">ROI: 10%</p>
                        <p class="text-xs text-blue-700 mt-1">Profit: $5 - $49.90</p>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Durée: 48 heures</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Support standard</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Retrait instantané</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-secondary w-full justify-center">
                        Choisir Bronze
                    </a>
                </div>

                <!-- Silver - Popular -->
                <div class="relative rounded-2xl border-2 border-primary-500 p-8 shadow-2xl">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-primary-500 px-4 py-1 text-sm font-semibold text-white shadow-lg">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Populaire
                        </span>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Silver</h3>
                        <p class="text-gray-600">Le plus choisi</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-5xl font-extrabold text-gray-900">$500</span>
                        <span class="text-gray-600 ml-2">- $999</span>
                    </div>
                    <div class="mb-6 rounded-lg bg-primary-50 p-4">
                        <p class="text-sm text-primary-900 font-semibold">ROI: 20%</p>
                        <p class="text-xs text-primary-700 mt-1">Profit: $100 - $199.80</p>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Durée: 48 heures</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Support prioritaire</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Retrait instantané</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary w-full justify-center">
                        Choisir Silver
                    </a>
                </div>

                <!-- Gold -->
                <div class="rounded-2xl border-2 border-gray-200 p-8 hover:border-primary-300 hover:shadow-xl transition-all duration-300">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Gold</h3>
                        <p class="text-gray-600">Maximum profit</p>
                    </div>
                    <div class="mb-6">
                        <span class="text-5xl font-extrabold text-gray-900">$1000</span>
                        <span class="text-gray-600 ml-2">+</span>
                    </div>
                    <div class="mb-6 rounded-lg bg-yellow-50 p-4">
                        <p class="text-sm text-yellow-900 font-semibold">ROI: 30%</p>
                        <p class="text-xs text-yellow-700 mt-1">Profit: $300+</p>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Durée: 48 heures</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Support VIP 24/7</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Retrait express</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-success w-full justify-center">
                        Choisir Gold
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 py-24">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-white opacity-10 blur-3xl"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl mb-6">
                Prêt à faire fructifier votre capital ?
            </h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Rejoignez plus de 10 000 investisseurs qui nous font confiance
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn bg-white text-primary-600 hover:bg-gray-100 shadow-xl btn-lg">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Commencer gratuitement
                </a>
                <a href="{{ route('login') }}" class="btn bg-primary-700 text-white hover:bg-primary-800 border-2 border-white/20 btn-lg">
                    Se connecter
                </a>
            </div>
        </div>
    </section>

    <x-testimonials />

    @push('styles')
    <style>
        .btn-lg {
            @apply px-8 py-4 text-lg;
        }
    </style>
    @endpush
</x-guest-layout>