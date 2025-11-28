<x-account-layout title="Mon Profil">
    <div class="mx-auto max-w-4xl" x-data="{ tab: 'profile' }">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="mt-2 text-sm text-gray-600">Gérez vos informations personnelles et paramètres</p>
        </div>

        <!-- Tabs -->
        <div class="card mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex gap-6">
                    <button @click="tab = 'profile'" 
                            :class="tab === 'profile' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil
                        </div>
                    </button>
                    <button @click="tab = 'password'" 
                            :class="tab === 'password' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Mot de passe
                        </div>
                    </button>
                    <button @click="tab = 'referral'" 
                            :class="tab === 'referral' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                            class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Parrainage
                        </div>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Profile Tab -->
        <div x-show="tab === 'profile'" class="space-y-8" style="display: none;">
            <!-- Avatar Section -->
            <div class="card">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Photo de profil</h2>
                    <p class="text-sm text-gray-600">Mettez à jour votre photo de profil</p>
                </div>

                <div class="flex items-center gap-6" x-data="avatarUpload()">
                    <!-- Avatar Display -->
                    <div class="relative">
                        @if(auth()->user()->getFirstMediaUrl('avatar'))
                            <img src="{{ auth()->user()->getFirstMediaUrl('avatar') }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-100"
                                 x-ref="avatarPreview">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center ring-4 ring-gray-100">
                                <span class="text-3xl font-bold text-white">
                                    {{ auth()->user()->initials }}
                                </span>
                            </div>
                        @endif
                        
                        <!-- Preview (hidden by default) -->
                        <img x-show="previewUrl" 
                             :src="previewUrl" 
                             x-ref="preview"
                             style="display: none;"
                             class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-100 absolute inset-0">
                    </div>

                    <!-- Upload Form -->
                    <div class="flex-1">
                        <form method="POST" action="{{ route('user.profile.update-avatar') }}" enctype="multipart/form-data" x-ref="avatarForm">
                            @csrf
                            @method('POST')
                            
                            <input type="file" 
                                   name="avatar" 
                                   id="avatar"
                                   accept="image/jpeg,image/jpg,image/png"
                                   class="sr-only"
                                   @change="handleFileSelect($event)"
                                   x-ref="fileInput">
                            
                            <div class="flex items-center gap-3">
                                <label for="avatar" class="btn btn-primary cursor-pointer">
                                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="uploading ? 'Upload en cours...' : 'Changer la photo'"></span>
                                </label>

                                @if(auth()->user()->getFirstMediaUrl('avatar'))
                                    <form method="POST" action="{{ route('user.profile.delete-avatar') }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-secondary"
                                                onclick="return confirm('Voulez-vous vraiment supprimer votre photo de profil ?')">
                                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </form>
                        <p class="mt-2 text-xs text-gray-500">JPG, PNG jusqu'à 2MB. Recommandé : 400x400px</p>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                    <p class="text-sm text-gray-600">Mettez à jour vos informations de profil</p>
                </div>

                <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name) }}"
                               required
                               class="input-field">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email) }}"
                               required
                               class="input-field">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone (optional) -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone <span class="text-gray-400 text-xs">(optionnel)</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}"
                               class="input-field"
                               placeholder="+229 XX XX XX XX">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country (optional) -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Pays <span class="text-gray-400 text-xs">(optionnel)</span>
                        </label>
                        <select id="country" name="country" class="input-field">
                            <option value="">Sélectionnez un pays</option>
                            <option value="BJ" {{ old('country', auth()->user()->country) === 'BJ' ? 'selected' : '' }}>Bénin</option>
                            <option value="TG" {{ old('country', auth()->user()->country) === 'TG' ? 'selected' : '' }}>Togo</option>
                            <option value="CI" {{ old('country', auth()->user()->country) === 'CI' ? 'selected' : '' }}>Côte d'Ivoire</option>
                            <option value="SN" {{ old('country', auth()->user()->country) === 'SN' ? 'selected' : '' }}>Sénégal</option>
                            <option value="FR" {{ old('country', auth()->user()->country) === 'FR' ? 'selected' : '' }}>France</option>
                            <option value="CA" {{ old('country', auth()->user()->country) === 'CA' ? 'selected' : '' }}>Canada</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                        <button type="submit" class="btn btn-primary">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Tab -->
        <div x-show="tab === 'password'" class="card" style="display: none;">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Modifier le mot de passe</h2>
                <p class="text-sm text-gray-600">Assurez-vous d'utiliser un mot de passe sécurisé</p>
            </div>

            <form method="POST" action="{{ route('user.profile.update-password') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe actuel <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required
                           class="input-field">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nouveau mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="input-field">
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           class="input-field">
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Modifier le mot de passe
                    </button>
                </div>
            </form>
        </div>

        <!-- Referral Tab -->
        <div x-show="tab === 'referral'" class="card" style="display: none;">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Programme de parrainage</h2>
                <p class="text-sm text-gray-600">Invitez vos amis et gagnez des commissions</p>
            </div>

            <!-- Info Banner -->
            <div class="mb-6 rounded-lg bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-primary-900">Gagnez 5% de commission !</h3>
                        <p class="mt-1 text-sm text-primary-800">
                            Partagez votre lien de parrainage et recevez 5% des investissements de vos filleuls.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Referral Link -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Votre lien de parrainage</label>
                <div class="flex gap-2">
                    <input type="text" 
                           id="referralLink"
                           value="{{ route('register', ['ref' => auth()->user()->referral_code]) }}" 
                           readonly
                           class="input-field flex-1 bg-gray-50">
                    <button type="button" 
                            onclick="copyReferralLink()"
                            class="btn btn-primary whitespace-nowrap">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copier
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Filleuls</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ auth()->user()->referrals_count ?? 0 }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Commission totale</p>
                            <p class="mt-2 text-3xl font-bold text-green-600">{{ number_format(auth()->user()->total_referral_commission ?? 0, 2, ',', ' ') }} $</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Copier le lien de parrainage
        function copyReferralLink() {
            const input = document.getElementById('referralLink');
            input.select();
            document.execCommand('copy');
            
            // Toast notification
            alert('Lien copié dans le presse-papier !');
        }

        // Avatar Upload avec Alpine.js
        function avatarUpload() {
            return {
                previewUrl: null,
                uploading: false,

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    
                    if (!file) return;

                    // Validation
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        alert('Veuillez sélectionner une image JPG ou PNG.');
                        return;
                    }

                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSize) {
                        alert('L\'image ne doit pas dépasser 2MB.');
                        return;
                    }

                    // Preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Auto-submit
                    this.uploading = true;
                    this.$refs.avatarForm.submit();
                }
            }
        }
    </script>
    @endpush
</x-account-layout>