<x-account-layout title="Retraits">
    <div class="mx-auto max-w-7xl" x-data="withdrawalForm()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes Retraits</h1>
            <p class="mt-2 text-sm text-gray-600">Retirez vos gains en toute sécurité</p>
        </div>

        <!-- Balance Banner -->
        <div class="mb-8 rounded-2xl bg-gradient-to-r from-green-600 to-green-700 p-8 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-100">Solde disponible</p>
                    <p class="mt-2 text-5xl font-bold">{{ number_format(auth()->user()->balance, 2, ',', ' ') }} $</p>
                    <p class="mt-2 text-sm text-green-100">Montant minimum de retrait : {{ number_format($minWithdrawal, 0, ',', ' ') }} $</p>
                </div>
                <div class="hidden sm:block">
                    <svg class="h-24 w-24 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Withdrawal Form -->
        @if(auth()->user()->balance >= $minWithdrawal)
            <div class="card mb-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Nouvelle demande de retrait</h2>
                    <p class="mt-1 text-sm text-gray-600">Complétez le formulaire pour effectuer un retrait</p>
                </div>

                <form method="POST" action="{{ route('user.withdrawals.store') }}" class="space-y-6">
                    @csrf

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant à retirer <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="amount" 
                                   name="amount" 
                                   x-model="amount"
                                   @input="calculateFees"
                                   min="{{ $minWithdrawal }}"
                                   max="{{ auth()->user()->balance }}"
                                   step="0.01"
                                   required
                                   class="input-field pr-12"
                                   placeholder="Entrez le montant">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">USD</span>
                            </div>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Breakdown -->
                    <div class="rounded-lg bg-primary-50 border border-primary-200 p-4">
                        <h3 class="text-sm font-semibold text-primary-900 mb-3">Récapitulatif</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700">Montant demandé</span>
                                <span class="font-semibold text-gray-900" x-text="formatMoney(amount)"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700">Frais (<span x-text="feePercentage"></span>%)</span>
                                <span class="font-semibold text-red-600" x-text="formatMoney(fees)"></span>
                            </div>
                            <div class="h-px bg-primary-200"></div>
                            <div class="flex justify-between">
                                <span class="text-sm font-semibold text-gray-900">Montant net</span>
                                <span class="text-lg font-bold text-green-600" x-text="formatMoney(netAmount)"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Méthode de paiement <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_method_id" name="payment_method_id" required class="input-field">
                            <option value="">Sélectionnez une méthode</option>
                            @foreach($paymentMethods as $type => $methods)
                                <optgroup label="{{ ucfirst($type) }}">
                                    @foreach($methods as $method)
                                        <option value="{{ $method->id }}">
                                            {{ $method->name }} - {{ $method->account_number }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Details -->
                    <div>
                        <label for="payment_details" class="block text-sm font-medium text-gray-700 mb-2">
                            Détails du compte <span class="text-red-500">*</span>
                        </label>
                        <textarea id="payment_details" 
                                  name="payment_details" 
                                  rows="4" 
                                  required
                                  class="input-field"
                                  placeholder='{"account_name": "Votre nom", "account_number": "Numéro de compte", "bank": "Nom de la banque"}'></textarea>
                        <p class="mt-1 text-xs text-gray-500">Format JSON requis avec vos informations bancaires</p>
                        @error('payment_details')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (optionnel)
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  class="input-field"
                                  placeholder="Ajoutez des notes ou instructions particulières..."></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <button type="submit" class="btn btn-success">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Demander le retrait
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-6 mb-8">
                <div class="flex">
                    <svg class="h-6 w-6 text-yellow-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Solde insuffisant</h3>
                        <p class="mt-2 text-sm text-yellow-700">
                            Votre solde actuel est de {{ number_format(auth()->user()->balance, 2, ',', ' ') }} $. 
                            Le montant minimum pour effectuer un retrait est de {{ number_format($minWithdrawal, 0, ',', ' ') }} $.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('user.investments.create') }}" class="btn btn-primary btn-sm">
                                Investir maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Withdrawals List -->
        <div class="card">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Historique des retraits</h2>
            </div>

            @if($withdrawals->isNotEmpty())
                <div class="space-y-4">
                    @foreach($withdrawals as $withdrawal)
                        <div class="rounded-lg border border-gray-200 p-4 hover:border-primary-300 hover:shadow-md transition-all duration-200">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-gray-900">{{ $withdrawal->formatted_net_amount }}</p>
                                        <p class="text-sm text-gray-600">Réf: <span class="font-mono">{{ $withdrawal->reference }}</span></p>
                                    </div>
                                </div>
                                <span class="badge badge-{{ $withdrawal->status_color }}">
                                    {{ $withdrawal->formatted_status }}
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-600">Date de demande</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $withdrawal->created_at->format('d M Y à H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Frais</p>
                                    <p class="text-sm font-medium text-red-600">{{ $withdrawal->formatted_fee }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('user.withdrawals.show', $withdrawal) }}" class="btn btn-secondary btn-sm">
                                    <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>
                                @if(in_array($withdrawal->status, ['pending', 'under_review']))
                                    <form method="POST" action="{{ route('user.withdrawals.destroy', $withdrawal) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler ce retrait ?')"
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
                <div class="mt-6">
                    {{ $withdrawals->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="mt-4 text-sm text-gray-600">Aucun retrait pour le moment</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function withdrawalForm() {
            return {
                amount: 0,
                fees: 0,
                netAmount: 0,
                feePercentage: {{ $feePercentage }},
                
                calculateFees() {
                    const amt = parseFloat(this.amount) || 0;
                    this.fees = (amt * this.feePercentage) / 100;
                    this.netAmount = amt - this.fees;
                },
                
                formatMoney(value) {
                    return new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(value || 0);
                }
            }
        }
    </script>
    @endpush
</x-account-layout>