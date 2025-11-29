<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Alert Banners -->
    @if($stats['pending_withdrawals'] > 0)
    <div class="mb-6 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-l-4 border-red-500 rounded-xl p-4 lg:p-5 shadow-sm" data-auto-dismiss>
        <div class="flex items-start gap-4">
            <div class="text-3xl">⚠️</div>
            <div class="flex-1">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                    {{ $stats['pending_withdrawals'] }} retraits en attente de validation
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Des utilisateurs attendent l'approbation de leurs demandes de retrait pour un montant total de ${{ number_format($stats['pending_withdrawals_amount'], 2) }}.
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.withdrawals.index') }}" 
                   class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-md">
                    Traiter maintenant
                </a>
                <button onclick="this.closest('[data-auto-dismiss]').remove()"
                        class="px-4 py-2 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors border border-gray-200 dark:border-gray-600">
                    Plus tard
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sky-500 to-blue-600"></div>
            
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Total Utilisateurs
                    </p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">
                        {{ number_format($stats['total_users']) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-sky-500/10 to-blue-600/5 dark:from-sky-500/20 dark:to-blue-600/10 flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 transition-transform">
                    👥
                </div>
            </div>
            
            <div class="flex items-center gap-2 mt-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-bold">
                    ↗️ +{{ $stats['new_users_30d'] }}
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">ce mois</span>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                +{{ number_format(($stats['new_users_30d'] / max($stats['total_users'] - $stats['new_users_30d'], 1)) * 100, 1) }}% vs mois précédent
            </p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Revenus Total
                    </p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">
                        ${{ number_format($stats['total_revenue'], 0) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500/10 to-emerald-600/5 dark:from-green-500/20 dark:to-emerald-600/10 flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 transition-transform">
                    💰
                </div>
            </div>
            
            <div class="flex items-center gap-2 mt-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-bold">
                    ↗️ +8.5%
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">ce mois</span>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                Objectif mensuel: $200,000
            </p>
        </div>

        <!-- Active Investments -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-600"></div>
            
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Investments Actifs
                    </p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">
                        {{ number_format($stats['active_investments']) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500/10 to-orange-600/5 dark:from-amber-500/20 dark:to-orange-600/10 flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 transition-transform">
                    💎
                </div>
            </div>
            
            <div class="flex items-center gap-2 mt-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-bold">
                    ↗️ +15
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">cette semaine</span>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                Valeur totale: ${{ number_format($stats['total_invested'], 0) }}
            </p>
        </div>

        <!-- Pending Withdrawals -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-600"></div>
            
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Retraits Pending
                    </p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white font-poppins">
                        ${{ number_format($stats['pending_withdrawals_amount'], 0) }}
                    </h3>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-500/10 to-rose-600/5 dark:from-red-500/20 dark:to-rose-600/10 flex items-center justify-center text-2xl shadow-lg group-hover:scale-110 transition-transform">
                    ⏳
                </div>
            </div>
            
            <div class="flex items-center gap-2 mt-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">
                    📊 {{ $stats['pending_withdrawals'] }} demandes
                </span>
            </div>
            <p class="text-xs text-red-500 dark:text-red-400 mt-2 font-semibold">
                Action requise
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white font-poppins">
                        Revenus quotidiens
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Évolution sur 7 jours
                    </p>
                </div>
                <div class="flex gap-2" x-data="{ period: '30d' }">
                    <button @click="period = '7d'" 
                            :class="period === '7d' ? 'bg-gradient-to-r from-sky-500 to-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                        7J
                    </button>
                    <button @click="period = '30d'" 
                            :class="period === '30d' ? 'bg-gradient-to-r from-sky-500 to-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                        30J
                    </button>
                    <button @click="period = '90d'" 
                            :class="period === '90d' ? 'bg-gradient-to-r from-sky-500 to-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                        90J
                    </button>
                </div>
            </div>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        <!-- Cards Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white font-poppins">
                    Répartition par cartes
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Distribution des investments
                </p>
            </div>
            <canvas id="plansChart" height="280"></canvas>
        </div>
    </div>

    <!-- Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white font-poppins">
                    Activité récente
                </h3>
                <a href="{{ route('admin.activity.index') }}" 
                   class="text-sm text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 font-semibold transition-colors">
                    Voir tout →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recent_activities as $activity)
                <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all cursor-pointer group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $activity['color'] }} flex items-center justify-center text-xl flex-shrink-0 shadow-md group-hover:scale-110 transition-transform">
                        {{ $activity['icon'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                            {{ $activity['title'] }}
                        </h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                            {{ $activity['description'] }}
                        </p>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 whitespace-nowrap">
                        {{ $activity['time'] }}
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-3">📊</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucune activité récente</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Top Investors -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white font-poppins">
                    Top 5 Investisseurs
                </h3>
                <a href="{{ route('admin.users.index', ['sort' => 'investments']) }}" 
                   class="text-sm text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 font-semibold transition-colors">
                    Classement complet →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($top_investors as $index => $investor)
                <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all cursor-pointer group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500/10 to-blue-600/5 dark:from-sky-500/20 dark:to-blue-600/10 flex items-center justify-center text-xl flex-shrink-0 shadow-md group-hover:scale-110 transition-transform">
                        @if($index === 0) 🥇
                        @elseif($index === 1) 🥈
                        @elseif($index === 2) 🥉
                        @else {{ $index + 1 }}️⃣
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">
                            {{ $investor->name }}
                        </h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                            {{ $investor->investments_count }} cartes actives · Membre depuis {{ $investor->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="text-sm font-black text-gray-900 dark:text-white whitespace-nowrap">
                        ${{ number_format($investor->total_invested, 0) }}
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-5xl mb-3">🏆</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucun investisseur pour le moment</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
        revenueGradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
        revenueGradient.addColorStop(1, 'rgba(14, 165, 233, 0.01)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chart_data['revenue']['labels']) !!},
                datasets: [{
                    label: 'Revenus ($)',
                    data: {!! json_encode($chart_data['revenue']['data']) !!},
                    borderColor: '#0EA5E9',
                    backgroundColor: revenueGradient,
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#0EA5E9',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 12,
                        borderColor: '#0EA5E9',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // Plans Chart
        const plansCtx = document.getElementById('plansChart').getContext('2d');
        new Chart(plansCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chart_data['cards']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chart_data['cards']['data']) !!},
                    backgroundColor: ['#CD7F32', '#C0C0C0', '#FFD700', '#0EA5E9'],
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 13 },
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 12,
                        borderColor: '#0EA5E9',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>