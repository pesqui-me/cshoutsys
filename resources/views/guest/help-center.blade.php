<x-guest-layout>
    <x-slot name="title">Centre d'aide</x-slot>

    <!-- Header -->
    <section class="bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg">
                        <svg class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">Centre d'aide</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Trouvez rapidement des réponses à vos questions sur PRIME BLOCK
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mt-12 max-w-2xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           placeholder="Rechercher dans l'aide..." 
                           class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-gray-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Getting Started -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 text-primary-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Démarrage rapide</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Comment créer un compte ?</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Vérifier mon identité</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Premier investissement</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Configuration de sécurité</a></li>
                    </ul>
                </div>

                <!-- Investments -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Investissements</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Types de cartes disponibles</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Calcul des rendements</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Durée d'investissement</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Annuler un investissement</a></li>
                    </ul>
                </div>

                <!-- Withdrawals -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-100 text-yellow-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Retraits</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Comment retirer mes fonds ?</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Délais de traitement</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Frais de retrait</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Méthodes de paiement</a></li>
                    </ul>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Sécurité</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Protéger mon compte</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Authentification à deux facteurs</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Mot de passe oublié</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Activité suspecte</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Mon compte</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Modifier mes informations</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Changer mon mot de passe</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Préférences de notification</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Fermer mon compte</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 mb-6">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Assistance</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Contacter le support</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-600 hover:text-primary-600 transition-colors">Questions fréquentes</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Signaler un problème</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-600 transition-colors">Temps de réponse</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-16 bg-gradient-to-br from-primary-50 to-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-12 shadow-xl border border-gray-100 text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Vous ne trouvez pas votre réponse ?</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Notre équipe support est disponible 24/7 pour vous aider avec toutes vos questions
                </p>
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    <a href="{{ route('contact') }}" class="btn btn-primary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contacter le support
                    </a>
                    <a href="{{ route('faq') }}" class="btn btn-secondary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Voir la FAQ
                    </a>
                </div>
                
                <!-- Support hours -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                        <div class="flex h-2 w-2 rounded-full bg-green-500">
                            <div class="h-2 w-2 animate-ping rounded-full bg-green-500"></div>
                        </div>
                        <span class="font-medium text-green-600">Support actif 24/7</span>
                        <span class="mx-2">•</span>
                        <span>Temps de réponse moyen : 2h</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>