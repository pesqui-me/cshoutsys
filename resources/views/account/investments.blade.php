<x-account-layout title="Mes Investissements">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes Investissements</h1>
                <p class="mt-2 text-sm text-gray-600">Suivez l'évolution de vos cartes d'investissement</p>
            </div>
            <a href="{{ route('user.investments.buy-card') }}" class="btn btn-primary">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle carte
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Investi</p>
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['total'], 2, ',', ' ') }} $</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 text-primary-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Actifs</p>
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">En Attente</p>
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Complétés</p>
                        <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="input-field">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Complété</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                @if(request()->hasAny(['status']))
                    <a href="{{ route('user.investments.index') }}" class="btn btn-secondary">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        <!-- Investments List -->
        @if($investments->isNotEmpty())
            <div class="space-y-6">
                @foreach($investments as $investment)
                    <div class="card hover:shadow-lg transition-shadow duration-200">
                        <!-- Header -->
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4 pb-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $investment->investmentcard->name }}</h3>
                                    <p class="text-sm text-gray-600">Réf: <span class="font-mono">{{ $investment->reference }}</span></p>
                                </div>
                            </div>
                            <span class="badge badge-{{ $investment->status_color }}">
                                {{ $investment->formatted_status }}
                            </span>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-4 lg:grid-cols-4">
                            <div>
                                <p class="text-sm text-gray-600">Montant investi</p>
                                <p class="mt-1 text-lg font-bold text-gray-900">{{ $investment->formatted_amount }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Profit attendu</p>
                                <p class="mt-1 text-lg font-bold text-green-600">{{ $investment->formatted_profit }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">ROI</p>
                                <p class="mt-1 text-lg font-bold text-primary-600">{{ $investment->investmentcard->roi_percentage }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date de création</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">{{ $investment->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <!-- Progress Bar (if active) -->
                        @if($investment->status === 'active' && $investment->remaining_time > 0)
                            <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4 mb-4" 
                                 x-data="countdown({{ $investment->remaining_time }})"
                                 x-init="startCountdown()">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-yellow-800">Temps restant</span>
                                    <span class="text-sm font-bold text-yellow-900" x-text="displayTime"></span>
                                </div>
                                <div class="w-full bg-yellow-200 rounded-full h-2">
                                    <div class="bg-yellow-600 h-2 rounded-full transition-all duration-1000" 
                                         :style="`width: ${Math.max(0, (remaining / {{ $investment->card->duration_hours * 3600 }}) * 100)}%`"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('user.investments.show', $investment) }}" class="btn btn-secondary btn-sm">
                                <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Détails
                            </a>
                            @if(in_array($investment->status, ['pending', 'processing']))
                                <form method="POST" action="{{ route('user.investments.destroy', $investment) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cet investissement ?')"
                                            class="btn btn-danger btn-sm">
                                        <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Annuler
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $investments->links() }}
            </div>
        @else
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun investissement</h3>
                <p class="mt-2 text-sm text-gray-600">Commencez à investir pour voir vos cartes ici.</p>
                <div class="mt-6">
                    <a href="{{ route('user.investments.buy-card') }}" class="btn btn-primary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Acheter une carte
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function countdown(totalSeconds) {
            return {
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
                    this.displayTime = `${h}h ${m}m ${s}s`;
                }
            }
        }
    </script>
    @endpush
</x-account-layout>