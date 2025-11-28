<x-account-layout title="Détails du retrait">
    <div class="mx-auto max-w-5xl">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('user.withdrawals.index') }}" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">Détails du retrait</h1>
                <p class="mt-1 text-sm text-gray-600">Réf: <span class="font-mono">{{ $withdrawal->reference }}</span></p>
            </div>
            <span class="badge badge-{{ $withdrawal->status_color }}">
                {{ $withdrawal->formatted_status }}
            </span>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="space-y-8 lg:col-span-2">
                <!-- Amount Card -->
                <div class="card text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Montant net à recevoir</p>
                    <p class="mt-2 text-4xl font-bold text-green-600">{{ $withdrawal->formatted_net_amount }}</p>
                </div>

                <!-- Breakdown -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails du montant</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Montant demandé</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $withdrawal->formatted_amount }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Frais de retrait ({{ $withdrawal->fee_percentage }}%)</span>
                            <span class="text-lg font-semibold text-red-600">-{{ $withdrawal->formatted_fee }}</span>
                        </div>
                        <div class="h-px bg-gray-200"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-base font-semibold text-gray-900">Montant net</span>
                            <span class="text-2xl font-bold text-green-600">{{ $withdrawal->formatted_net_amount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Méthode de paiement</h3>
                    <div class="rounded-lg bg-gray-50 p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span class="font-semibold text-gray-900">{{ $withdrawal->paymentMethod->name }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $withdrawal->paymentMethod->type }}</p>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails du compte</h3>
                    <div class="rounded-lg bg-gray-50 p-4">
                        <dl class="space-y-2">
                            @foreach($withdrawal->payment_details as $key => $value)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="text-sm font-mono text-gray-900">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <!-- Notes -->
                @if($withdrawal->notes)
                    <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-900">Note ajoutée</p>
                                <p class="mt-1 text-sm text-yellow-800">{{ $withdrawal->notes }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Rejection Reason -->
                @if($withdrawal->status === 'rejected' && $withdrawal->rejection_reason)
                    <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-900">Raison du rejet</p>
                                <p class="mt-1 text-sm text-red-800">{{ $withdrawal->rejection_reason }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Admin Notes -->
                @if($withdrawal->admin_notes)
                    <div class="rounded-lg bg-blue-50 border border-blue-200 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-900">Note de l'administrateur</p>
                                <p class="mt-1 text-sm text-blue-800">{{ $withdrawal->admin_notes }}</p>
                            </div>
                        </div>
                    </div>
                @endif

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
                                <p class="text-sm font-semibold text-gray-900">Demande créée</p>
                                <p class="mt-1 text-xs text-gray-600">{{ $withdrawal->created_at->format('d M Y à H:i') }}</p>
                            </div>
                        </div>

                        <!-- Approved -->
                        @if($withdrawal->approved_at)
                            <div class="relative">
                                <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-green-600 ring-4 ring-white">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="rounded-lg bg-green-50 p-4">
                                    <p class="text-sm font-semibold text-green-900">Retrait approuvé</p>
                                    <p class="mt-1 text-xs text-green-700">{{ $withdrawal->approved_at->format('d M Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Rejected -->
                        @if($withdrawal->rejected_at)
                            <div class="relative">
                                <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-red-600 ring-4 ring-white">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="rounded-lg bg-red-50 p-4">
                                    <p class="text-sm font-semibold text-red-900">Retrait rejeté</p>
                                    <p class="mt-1 text-xs text-red-700">{{ $withdrawal->rejected_at->format('d M Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Completed -->
                        @if($withdrawal->completed_at)
                            <div class="relative">
                                <div class="absolute left-[-2rem] flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 ring-4 ring-white">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="rounded-lg bg-blue-50 p-4">
                                    <p class="text-sm font-semibold text-blue-900">Paiement effectué</p>
                                    <p class="mt-1 text-xs text-blue-700">{{ $withdrawal->completed_at->format('d M Y à H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-600">Référence</p>
                            <p class="mt-1 text-sm font-mono text-gray-900">{{ $withdrawal->reference }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Date de création</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $withdrawal->created_at->format('d M Y à H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Statut</p>
                            <span class="mt-1 inline-block badge badge-{{ $withdrawal->status_color }}">
                                {{ $withdrawal->formatted_status }}
                            </span>
                        </div>
                        @if(in_array($withdrawal->status, ['pending', 'under_review', 'approved', 'processing']))
                            <div class="rounded-lg bg-blue-50 p-3">
                                <p class="text-xs text-blue-900">
                                    <strong>Délai estimé:</strong><br>
                                    24-48 heures ouvrables
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cancel Button -->
                @if(in_array($withdrawal->status, ['pending', 'under_review']))
                    <form method="POST" action="{{ route('user.withdrawals.destroy', $withdrawal) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler ce retrait ?')"
                                class="w-full btn btn-danger">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler le retrait
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
                            <p class="mt-1 text-xs text-primary-800">Notre support est disponible 24/7</p>
                            <a href="{{ route('user.support.create') }}" class="mt-2 inline-flex items-center text-xs font-medium text-primary-600 hover:text-primary-700">
                                Contacter le support
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
</x-account-layout>