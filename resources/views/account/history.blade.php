<x-account-layout title="Historique des Transactions">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Historique des Transactions</h1>
            <p class="mt-2 text-sm text-gray-600">Consultez l'historique complet de toutes vos transactions</p>
        </div>

        <!-- Filters -->
        <div class="card mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <!-- Type Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" id="type" onchange="this.form.submit()" class="input-field">
                        <option value="">Tous les types</option>
                        <option value="profit_credit" {{ request('type') === 'profit_credit' ? 'selected' : '' }}>Crédit de profit</option>
                        <option value="investment_purchase" {{ request('type') === 'investment_purchase' ? 'selected' : '' }}>Achat d'investissement</option>
                        <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Retrait</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="input-field">
                        <option value="">Tous les statuts</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Complété</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <!-- Reset Button -->
                @if(request()->hasAny(['type', 'status']))
                    <a href="{{ route('user.transactions.index') }}" class="btn btn-secondary">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        <!-- Transactions Table -->
        @if($transactions->isNotEmpty())
            <!-- Desktop View -->
            <div class="card overflow-hidden hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Transaction
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($transactions as $transaction)
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
                                        {{ $transaction->created_at->format('d M Y à H:i') }}
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
            </div>

            <!-- Mobile View -->
            <div class="space-y-4 md:hidden">
                @foreach($transactions as $transaction)
                    <div class="card">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
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
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->formatted_type }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y à H:i') }}</p>
                                </div>
                            </div>
                            <span class="badge badge-{{ $transaction->status_color }}">
                                {{ $transaction->formatted_status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-600">{{ Str::limit($transaction->description, 40) }}</p>
                            <p class="text-lg font-bold {{ $transaction->type === 'profit_credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'profit_credit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune transaction</h3>
                <p class="mt-2 text-sm text-gray-600">Vos transactions apparaîtront ici une fois que vous commencerez à investir.</p>
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
</x-account-layout>