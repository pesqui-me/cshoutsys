<x-account-layout title="Tableau de Bord">
    <div class="mx-auto max-w-7xl">
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-10 shadow-xl sm:px-12 sm:py-16">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Bienvenue, {{ auth()->user()->name }} ! 👋
                    </h1>
                    <p class="mt-2 text-lg text-primary-100">
                        Consultez votre tableau de bord pour un aperçu de vos investissements
                    </p>
                </div>
                <div class="absolute right-0 top-0 -mr-10 -mt-10 h-64 w-64 rounded-full bg-primary-500 opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 h-64 w-64 rounded-full bg-primary-800 opacity-20 blur-3xl"></div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Solde Disponible -->
            <div class="card group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600">Solde Disponible</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ number_format(auth()->user()->balance, 2, ',', ' ') }} $
                        </p>
                        <p class="mt-2 flex items-center text-sm text-green-600">
                            <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Disponible pour retrait
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600 group-hover:bg-green-200 transition-colors duration-200">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Investi -->
            <div class="card group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Investi</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ number_format(auth()->user()->total_invested, 2, ',', ' ') }} $
                        </p>
                        <p class="mt-2 flex items-center text-sm text-primary-600">
                            <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            {{ auth()->user()->active_investments }} carte(s) active(s)
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary-100 text-primary-600 group-hover:bg-primary-200 transition-colors duration-200">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Gains en Attente -->
            <div class="card group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600">Gains en Attente</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ number_format(auth()->user()->pending_profit, 2, ',', ' ') }} $
                        </p>
                        <p class="mt-2 flex items-center text-sm text-yellow-600">
                            <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            En cours de traitement
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-yellow-100 text-yellow-600 group-hover:bg-yellow-200 transition-colors duration-200">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Gagné -->
            <div class="card group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Gagné</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ number_format(auth()->user()->total_profit, 2, ',', ' ') }} $
                        </p>
                        <p class="mt-2 flex items-center text-sm text-green-600">
                            <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Profits complétés
                        </p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600 group-hover:bg-green-200 transition-colors duration-200">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @if($activeInvestments->isNotEmpty())
            @php
                $nextInvestment = $activeInvestments->first();
                $remainingTime = $nextInvestment->remaining_time;
            @endphp
            
            @if($remainingTime > 0)
                <!-- Countdown -->
                <div class="mb-8 card" 
                     x-data="countdown({{ $remainingTime }})"
                     x-init="startCountdown()">
                    <div class="text-center">
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 mb-4">
                                <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Prochain gain disponible dans</h3>
                        </div>

                        <div class="flex justify-center gap-4 sm:gap-8 mb-6">
                            <div class="text-center">
                                <div class="flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold" x-text="hours">00</span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-gray-600">Heures</p>
                            </div>
                            <div class="flex items-center text-3xl font-bold text-primary-600 pb-8">:</div>
                            <div class="text-center">
                                <div class="flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold" x-text="minutes">00</span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-gray-600">Minutes</p>
                            </div>
                            <div class="flex items-center text-3xl font-bold text-primary-600 pb-8">:</div>
                            <div class="text-center">
                                <div class="flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                                    <span class="text-3xl sm:text-4xl font-bold" x-text="seconds">00</span>
                                </div>
                                <p class="mt-2 text-sm font-medium text-gray-600">Secondes</p>
                            </div>
                        </div>

                        <div class="inline-flex items-center justify-center rounded-lg bg-primary-50 px-4 py-2 text-sm font-medium text-primary-700">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Investissement de {{ $nextInvestment->formatted_amount }} · Gain attendu: {{ $nextInvestment->formatted_profit }}
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Quick Actions -->
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('user.investments.buy-card') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 p-6 text-white shadow-lg transition-all duration-200 hover:shadow-xl hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-primary-100">Action rapide</p>
                        <p class="mt-1 text-xl font-bold">Acheter une carte</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white bg-opacity-20">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
            </a>

            @if(auth()->user()->balance >= 50)
                <a href="{{ route('user.withdrawals.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-green-600 to-green-700 p-6 text-white shadow-lg transition-all duration-200 hover:shadow-xl hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-100">Action rapide</p>
                            <p class="mt-1 text-xl font-bold">Retirer mes gains</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white bg-opacity-20">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endif
        </div>

        <!-- Recent Transactions -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Dernières transactions</h3>
                <a href="{{ route('user.transactions.index') }}" class="flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                    Voir tout
                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($recentTransactions->isNotEmpty())
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Transaction</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full 
                                                {{ $transaction->type === 'profit_credit' ? 'bg-green-100 text-green-600' : 
                                                   ($transaction->type === 'withdrawal' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600') }}">
                                                @if($transaction->type === 'profit_credit')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                    </svg>
                                                @elseif($transaction->type === 'withdrawal')
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $transaction->formatted_type }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($transaction->description, 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $transaction->created_at->format('d M Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold {{ $transaction->type === 'profit_credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'profit_credit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="badge badge-{{ $transaction->status_color }}">
                                            {{ $transaction->formatted_status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune transaction</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez à investir pour voir vos transactions ici.</p>
                    <div class="mt-6">
                        <a href="{{ route('user.investments.buy-card') }}" class="btn btn-primary">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Commencer à investir
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function countdown(totalSeconds) {
            return {
                hours: '00',
                minutes: '00',
                seconds: '00',
                interval: null,
                remaining: totalSeconds,
                
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
                }
            }
        }
    </script>
    @endpush
</x-account-layout>