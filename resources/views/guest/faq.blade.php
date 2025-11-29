<x-guest-layout>
    <x-slot name="title">FAQ</x-slot>

    <section class="bg-gradient-to-br from-primary-50 via-white to-primary-50 py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">Questions Fréquentes</h1>
                <p class="text-xl text-gray-600">
                    Trouvez rapidement des réponses aux questions les plus courantes
                </p>
            </div>

            <div class="space-y-4" x-data="{ open: null }">
                <!-- Q1 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Comment créer un compte sur PRIME BLOCK ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600">
                            Pour créer un compte, cliquez sur "S'inscrire" en haut de la page, remplissez le formulaire avec vos informations, vérifiez votre email, et complétez la vérification d'identité. Le processus prend environ 5 minutes.
                        </p>
                    </div>
                </div>

                <!-- Q2 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Quels sont les rendements attendus ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 mb-3">
                            Les rendements varient selon la carte d'investissement choisie :
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                            <li>Carte Bronze (200$) : 50$ de profit en 7 jours</li>
                            <li>Carte Silver (500$) : 150$ de profit en 7 jours</li>
                            <li>Carte Gold (1000$) : 350$ de profit en 7 jours</li>
                            <li>Carte Platinum (1500$) : 600$ de profit en 7 jours</li>
                        </ul>
                    </div>
                </div>

                <!-- Q3 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Comment effectuer un retrait ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600">
                            Connectez-vous à votre compte, accédez à la section "Retraits", sélectionnez le montant, choisissez votre méthode de paiement (virement bancaire, carte, crypto), et confirmez. Le traitement prend 24-72h selon la méthode choisie.
                        </p>
                    </div>
                </div>

                <!-- Q4 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">La plateforme est-elle sécurisée ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 4 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 mb-3">
                            Absolument ! PRIME BLOCK utilise les technologies de sécurité les plus avancées :
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                            <li>Cryptage SSL 256 bits pour toutes les données</li>
                            <li>Authentification à deux facteurs (2FA)</li>
                            <li>Stockage sécurisé des fonds</li>
                            <li>Conformité aux régulations financières</li>
                            <li>Audits de sécurité réguliers</li>
                        </ul>
                    </div>
                </div>

                <!-- Q5 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 5 ? null : 5" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Puis-je annuler un investissement ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 5 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 5" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600">
                            Oui, vous pouvez annuler un investissement avant la fin de la période de 7 jours. Cependant, les profits déjà générés ne seront pas inclus dans le remboursement. Le capital initial vous sera retourné sous 24-48h.
                        </p>
                    </div>
                </div>

                <!-- Q6 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 6 ? null : 6" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Y a-t-il des frais cachés ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 6 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 6" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 mb-3">
                            Non, PRIME BLOCK est transparent sur tous les frais :
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                            <li>Investissement : 0% de frais</li>
                            <li>Retrait bancaire : 2% du montant</li>
                            <li>Retrait crypto : Frais réseau uniquement</li>
                            <li>Aucuns frais d'inactivité</li>
                        </ul>
                    </div>
                </div>

                <!-- Q7 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = open === 7 ? null : 7" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900">Comment contacter le support ?</span>
                        <svg class="h-5 w-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open === 7 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 7" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 mb-3">
                            Notre support est disponible 24/7 via plusieurs canaux :
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                            <li>Email : support@primeblock.com</li>
                            <li>Téléphone : +33 1 23 45 67 89</li>
                            <li>Chat en direct depuis votre tableau de bord</li>
                            <li>Formulaire de contact sur notre site</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Still have questions CTA -->
            <div class="mt-16 text-center bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Vous avez encore des questions ?</h3>
                <p class="text-gray-600 mb-6">Notre équipe support est là pour vous aider</p>
                <a href="{{ route('contact') }}" class="btn btn-primary inline-flex">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contactez-nous
                </a>
            </div>
        </div>
    </section>
</x-guest-layout>