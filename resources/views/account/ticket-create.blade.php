<x-account-layout title="Nouveau Ticket">
    <div class="mx-auto max-w-5xl">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('user.support.index') }}" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Créer un ticket de support</h1>
                <p class="mt-1 text-sm text-gray-600">Décrivez votre problème et notre équipe vous aidera</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Form -->
            <div class="lg:col-span-2">
                <form method="POST" 
                      action="{{ route('user.support.store') }}" 
                      enctype="multipart/form-data" 
                      class="card space-y-6"
                      x-data="{ priority: '{{ old('priority', 'medium') }}' }">
                    @csrf

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Sujet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}"
                               required
                               minlength="5"
                               maxlength="255"
                               class="input-field"
                               placeholder="Décrivez brièvement votre problème">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select id="category" name="category" required class="input-field">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="payment" {{ old('category') === 'payment' ? 'selected' : '' }}>Paiement</option>
                            <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>Technique</option>
                            <option value="account" {{ old('category') === 'account' ? 'selected' : '' }}>Compte</option>
                            <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>Général</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority avec Alpine.js -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Low Priority -->
                            <label @click="priority = 'low'" 
                                   :class="priority === 'low' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-primary-300'"
                                   class="relative flex cursor-pointer rounded-lg border bg-white p-4 transition-all duration-200">
                                <input type="radio" 
                                       name="priority" 
                                       value="low" 
                                       x-model="priority"
                                       class="sr-only" 
                                       required>
                                <div class="flex flex-col items-center w-full">
                                    <svg class="h-6 w-6 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Basse</span>
                                </div>
                            </label>

                            <!-- Medium Priority -->
                            <label @click="priority = 'medium'" 
                                   :class="priority === 'medium' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-300 hover:border-primary-300'"
                                   class="relative flex cursor-pointer rounded-lg border bg-white p-4 transition-all duration-200">
                                <input type="radio" 
                                       name="priority" 
                                       value="medium" 
                                       x-model="priority"
                                       class="sr-only">
                                <div class="flex flex-col items-center w-full">
                                    <svg class="h-6 w-6 text-yellow-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Moyenne</span>
                                </div>
                            </label>

                            <!-- High Priority -->
                            <label @click="priority = 'high'" 
                                   :class="priority === 'high' ? 'border-red-500 bg-red-50' : 'border-gray-300 hover:border-primary-300'"
                                   class="relative flex cursor-pointer rounded-lg border bg-white p-4 transition-all duration-200">
                                <input type="radio" 
                                       name="priority" 
                                       value="high" 
                                       x-model="priority"
                                       class="sr-only">
                                <div class="flex flex-col items-center w-full">
                                    <svg class="h-6 w-6 text-red-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Haute</span>
                                </div>
                            </label>
                        </div>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  minlength="10"
                                  maxlength="5000"
                                  class="input-field"
                                  placeholder="Décrivez votre problème en détail...">{{ old('message') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Minimum 10 caractères, maximum 5000</p>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachments -->
                    <div>
                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">
                            Pièces jointes (optionnel)
                        </label>
                        <div class="mt-1 flex justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 hover:border-primary-400 transition-colors duration-200">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="attachments" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary-600 hover:text-primary-500">
                                        <span>Télécharger des fichiers</span>
                                        <input id="attachments" name="attachments[]" type="file" class="sr-only" multiple accept="image/*,.pdf,.doc,.docx">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, PDF, DOC jusqu'à 5MB chacun</p>
                            </div>
                        </div>
                        @error('attachments')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('user.support.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Envoyer le ticket
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Tips -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Conseils</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Soyez précis</p>
                                <p class="text-xs text-gray-600">Décrivez votre problème en détail</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Captures d'écran</p>
                                <p class="text-xs text-gray-600">Ajoutez des images si nécessaire</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Priorité</p>
                                <p class="text-xs text-gray-600">Choisissez la bonne priorité</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- FAQ -->
                <div class="rounded-lg bg-green-50 border border-green-200 p-4">
                    <h3 class="text-sm font-semibold text-green-900 mb-3">Questions fréquentes</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-green-900">Délai de retrait ?</p>
                            <p class="text-xs text-green-800">24-48 heures ouvrables</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-900">Montant minimum ?</p>
                            <p class="text-xs text-green-800">50 USD pour les retraits</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-900">Frais de retrait ?</p>
                            <p class="text-xs text-green-800">Variable selon la méthode</p>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact direct</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <a href="mailto:support@cashout.com" class="text-xs text-primary-600 hover:text-primary-700">support@cashout.com</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Délai de réponse</p>
                                <p class="text-xs text-gray-600">Moins de 24 heures</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-account-layout>