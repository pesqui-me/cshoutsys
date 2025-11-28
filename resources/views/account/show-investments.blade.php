<x-account-layout title="Détails de l'investissement">
    <div class="mx-auto max-w-5xl">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('user.investments.index') }}" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">Détails de l'investissement</h1>
                <p class="mt-1 text-sm text-gray-600">Réf: <span class="font-mono">{{ $investment->reference }}</span></p>
            </div>
            <span class="badge badge-{{ $investment->status_color }}">
                {{ $investment->formatted_status }}
            </span>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="space-y-8 lg:col-span-2">
                <!-- Investment Card -->
                <div class="card">
                    <div class="flex items-start gap-6">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg flex-shrink-0">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $investment->InvestmentCard->name }}</h2>
                            <p class="mt-1 text-sm text-gray-600">Carte d'investissement</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-6">
                        <div class="rounded-lg bg-gray-50 p-4">
                            <p class="text-sm text-gray-600">Montant investi</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                        </div>
                        <div class="rounded-lg bg-green-50 p-4">
                            <p class="text-sm text-green-700">Profit attendu</p>
                            <p class="mt-2 text-2xl font-bold text-green-600">{{ $investment->formatted_profit }}</p>
                        </div>
                    </div>

                    <!-- Progress Bar (if active) -->
                    @if($investment->status === 'active' && $investment->remaining_time > 0)
                        <div class="mt-6 rounded-lg bg-yellow-50 border border-yellow-200 p-6" 
                             x-data="countdown({{ $investment->remaining_time }})"
                             x-init="startCountdown()">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-semibold text-yellow-900">Temps restant avant profit</h3>
                                <span class="text-sm font-bold text-yellow-900" x-text="displayTime"></span>
                            </div>
                            <div class="w-full bg-yellow-200 rounded-full h-3">
                                <div class="bg-yellow-600 h-3 rounded-full transition-all duration-1000" 
                                     :style="`width: ${Math.max(0, (remaining / {{ $investment->card->duration_hours * 3600 }}) * 100)}%`"></div>
                            </div>
                            <p class="mt-3 text-xs text-yellow-800">
                                Votre profit sera crédité automatiquement à la fin du compte à rebours
                            </p>
                        </div>
                    @endif

                    <!-- Countdown Timer (if active) -->
                    @if($investment->status === 'active' && $investment->remaining_time > 0)
                        <div class="mt-6 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 p-6"
                             x-data="countdown({{ $investment->remaining_time }})"
                             x-init="startCountdown()">
                            <h3 class="text-center text-sm font-semibold text-primary-900 mb-4">Compte à rebours</h3>
                            <div class="flex justify-center gap-4">
                                <div class="text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-md">
                                        <span class="text-2xl font-bold text-primary-600" x-text="hours">00</span>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-primary-900">Heures</p>
                                </div>
                                <div class="flex items-center text-2xl font-bold text-primary-600 pb-6">:</div>
                                <div class="text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-md">
                                        <span class="text-2xl font-bold text-primary-600" x-text="minutes">00</span>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-primary-900">Minutes</p>
                                </div>
                                <div class="flex items-center text-2xl font-bold text-primary-600 pb-6">:</div>
                                <div class="text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white shadow-md">
                                        <span class="text-2xl font-bold text-primary-600" x-text="seconds">00</span>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-primary-900">Secondes</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Timeline -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Chronologie</h3>
                    <div class="relative space-y-8 pl-8">
                        <!-- Line -->
                        <div class="absolute left-2 top-3 bottom-3 w-0.5 bg-gray-200"></div>

                        <!-- Created -->
                        <div class="relative">
                            <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 ring-4 ring-white">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Investissement créé</p>
                                <p class="mt-1 text-xs text-gray-600">{{ $investment->created_at->format('d M Y à H:i') }}</p>
                            </div>
                        </div>

                        <!-- Activated -->
                        @if($investment->activated_at)
                            <div class="relative">
                                <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-green-600 ring-4 ring-white">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="rounded-lg bg-green-50 p-4">
                                    <p class="text-sm font-semibold text-green-900">Investissement activé</p>
                                    <p class="mt-1 text-xs text-green-700">{{ $investment->activated_at->format('d M Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Completed -->
                        @if($investment->completed_at)
                            <div class="relative">
                                <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 ring-4 ring-white">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="rounded-lg bg-blue-50 p-4">
                                    <p class="text-sm font-semibold text-blue-900">Profit crédité</p>
                                    <p class="mt-1 text-xs text-blue-700">{{ $investment->completed_at->format('d M Y à H:i') }}</p>
                                    <p class="mt-2 text-sm font-bold text-green-600">+{{ $investment->formatted_profit }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Details Card -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-600">ROI</p>
                            <p class="mt-1 text-xl font-bold text-primary-600">{{ $investment->investmentcard->roi_percentage }}%</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Durée</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $investment->investmentcard->duration_hours }} heures</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Méthode de paiement</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $investment->transactions->first()->PaymentMethod->name }}</p>
                            <p class="text-xs text-gray-500">{{ $investment->transactions->first()->PaymentMethod->type }}</p>
                        </div>
                        @if($investment->payment_proof_url)
                            <div>
                                <p class="text-xs text-gray-600 mb-2">Preuve de paiement</p>
                                <a href="{{ $investment->payment_proof_url }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Voir le fichier
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cancel Button -->
                @if(in_array($investment->status, ['pending', 'processing']))
                    <form method="POST" action="{{ route('user.investments.destroy', $investment) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cet investissement ?')"
                                class="w-full btn btn-danger">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler l'investissement
                        </button>
                    </form>
                @endif

                <!-- Help Banner -->
                <div class="rounded-lg bg-primary-50 border border-primary-200 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-primary-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-primary-900">Besoin d'aide ?</p>
                            <p class="mt-1 text-xs text-primary-800">Contactez notre support si vous avez des questions.</p>
                            <a href="{{ route('user.support.create') }}" class="mt-2 inline-flex items-center text-xs font-medium text-primary-600 hover:text-primary-700">
                                Créer un ticket
                                <svg class="ml-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function countdown(totalSeconds) {
            return {
                hours: '00',
                minutes: '00',
                seconds: '00',
                remaining: totalSeconds,
                displayTime: '',
                interval: null,
                
                startCountdown() {
                    this.updateDisplay();
                    this.interval = setInterval(() => {
                        if (this.remaining <= 0) {
                            clearInterval(this.interval);
                            window.location.reload();
                            return;
                        }
                        this.remaining--;
                        this.updateDisplay();
                    }, 1000);
                },
                
                updateDisplay() {
                    const h = Math.floor(this.remaining / 3600);
                    const m = Math.floor((this.remaining % 3600) / 60);
                    const s = this.remaining % 60;
                    
                    this.hours = String(h).padStart(2, '0');
                    this.minutes = String(m).padStart(2, '0');
                    this.seconds = String(s).padStart(2, '0');
                    this.displayTime = `${h}h ${m}m ${s}s`;
                }
            }
        }
    </script>
    @endpush
</x-account-layout>