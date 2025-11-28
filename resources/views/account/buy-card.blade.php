<x-account-layout title="Acheter une Carte">
    <div class="mx-auto max-w-7xl" x-data="cardSelector()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Acheter une Carte d'Investissement</h1>
            <p class="mt-2 text-sm text-gray-600">Choisissez la carte qui correspond à vos objectifs d'investissement</p>
        </div>

        <!-- Info Banner -->
        <div class="mb-8 rounded-xl bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200 p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-primary-900">Comment ça marche ?</h3>
                    <p class="mt-1 text-sm text-primary-800">
                        Sélectionnez une carte, effectuez votre paiement, et votre investissement sera activé sous 48h. 
                        Vous recevrez vos profits automatiquement à la fin de la période.
                    </p>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($cards as $card)
                <div @click="selectCard({{ $card->id }}, {{ $card->price }}, '{{ $card->name }}')"
                     :class="selectedCard === {{ $card->id }} ? 'ring-2 ring-primary-500 shadow-lg' : 'hover:shadow-md'"
                     class="card cursor-pointer group transition-all duration-200 relative overflow-hidden">
                    
                    <!-- Selected Badge -->
                    <div x-show="selectedCard === {{ $card->id }}" 
                         class="absolute top-4 right-4 flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-white shadow-lg">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <!-- Card Icon -->
                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>

                    <!-- Card Name -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $card->name }}</h3>

                    <!-- Pricing -->
                    <div class="mb-4 rounded-lg bg-gray-50 p-4">
                        <div class="flex items-baseline justify-between mb-2">
                            <span class="text-sm text-gray-600">Investissement</span>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($card->price, 0, ',', ' ') }} $</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-sm text-gray-600">Profit net</span>
                            <span class="text-xl font-bold text-green-600">+{{ number_format($card->profit, 0, ',', ' ') }} $</span>
                        </div>
                    </div>

                    <!-- ROI Badge -->
                    <div class="mb-4 inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                        <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        ROI {{ $card->roi_percentage }}%
                    </div>

                    <!-- Duration Warning -->
                    <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-3">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-yellow-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs text-yellow-800">Durée : 48 heures</span>
                        </div>
                    </div>

                    <!-- Select Button -->
                    <button type="button" 
                            @click="selectCard({{ $card->id }}, {{ $card->price }}, '{{ $card->name }}')"
                            :class="selectedCard === {{ $card->id }} ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            class="mt-4 w-full rounded-lg px-4 py-2.5 font-semibold transition-all duration-200">
                        <span x-show="selectedCard === {{ $card->id }}">Sélectionné</span>
                        <span x-show="selectedCard !== {{ $card->id }}">Choisir cette carte</span>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Purchase Form -->
        <div x-show="selectedCard" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="card border-2 border-primary-200"
             style="display: none;">
            
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Confirmer votre achat</h2>
                <p class="mt-1 text-sm text-gray-600">Complétez les informations pour finaliser votre investissement</p>
            </div>

            <!-- Summary -->
            <div class="mb-6 rounded-lg bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200 p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-primary-900">Carte sélectionnée</span>
                    <span class="text-lg font-bold text-primary-900" x-text="selectedCardName"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-primary-900">Montant à payer</span>
                    <span class="text-2xl font-bold text-primary-600" x-text="selectedCardPrice + ' $'"></span>
                </div>
            </div>

            <form method="POST" action="{{ route('user.investments.purchase') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="card_id" x-model="selectedCard">

                <!-- Payment Method -->
                <div>
                    <label for="payment_method_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Méthode de paiement <span class="text-red-500">*</span>
                    </label>
                    <select id="payment_method_id" 
                            name="payment_method_id" 
                            required
                            class="input-field">
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

                <!-- Payment Proof -->
                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                        Preuve de paiement <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 hover:border-primary-400 transition-colors duration-200">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                <label for="payment_proof" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary-600 hover:text-primary-500">
                                    <span>Télécharger un fichier</span>
                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" required accept="image/*,.pdf">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, PDF jusqu'à 10MB</p>
                        </div>
                    </div>
                    @error('payment_proof')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="button" 
                            @click="selectedCard = null"
                            class="btn btn-secondary">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirmer l'achat
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function cardSelector() {
            return {
                selectedCard: null,
                selectedCardPrice: 0,
                selectedCardName: '',
                
                selectCard(id, price, name) {
                    this.selectedCard = id;
                    this.selectedCardPrice = price;
                    this.selectedCardName = name;
                    
                    // Scroll to form
                    this.$nextTick(() => {
                        const form = document.querySelector('[x-show="selectedCard"]');
                        if (form) {
                            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-account-layout>