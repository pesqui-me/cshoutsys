<x-guest-layout>
    <x-slot name="title">Contact</x-slot>

    <section class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">Contactez-nous</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Notre équipe est là pour vous aider. Envoyez-nous un message et nous vous répondrons dans les plus brefs délais.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Email -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                    <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-2xl bg-primary-100 text-primary-600 mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600 mb-4">Envoyez-nous un email</p>
                    <a href="mailto:support@primeblock.com" class="text-primary-600 hover:text-primary-700 font-semibold">
                        support@primeblock.com
                    </a>
                </div>

                <!-- Phone -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                    <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-2xl bg-green-100 text-green-600 mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Téléphone</h3>
                    <p class="text-gray-600 mb-4">Appelez-nous</p>
                    <a href="tel:+33123456789" class="text-green-600 hover:text-green-700 font-semibold">
                        +33 1 23 45 67 89
                    </a>
                </div>

                <!-- Support 24/7 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                    <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-2xl bg-yellow-100 text-yellow-600 mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Disponibilité</h3>
                    <p class="text-gray-600 mb-4">Support actif</p>
                    <div class="flex items-center justify-center gap-2">
                        <div class="flex h-2 w-2 rounded-full bg-green-500">
                            <div class="h-2 w-2 animate-ping rounded-full bg-green-500"></div>
                        </div>
                        <span class="text-green-600 font-semibold">24/7 Disponible</span>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-12">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" class="input-field" placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" class="input-field" placeholder="vous@exemple.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                            <select class="input-field">
                                <option>Question générale</option>
                                <option>Problème technique</option>
                                <option>Investissement</option>
                                <option>Retrait</option>
                                <option>Sécurité</option>
                                <option>Autre</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea rows="6" class="input-field" placeholder="Décrivez votre question ou problème..."></textarea>
                        </div>

                        <button type="submit" class="w-full btn btn-primary justify-center">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>