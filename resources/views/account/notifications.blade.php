<x-account-layout title="Notifications">
    <div class="mx-auto max-w-4xl">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                <p class="mt-2 text-sm text-gray-600">Restez informé de toutes vos activités</p>
            </div>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('user.notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        @if($notifications->isNotEmpty())
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    <div class="card {{ $notification->read_at ? '' : 'bg-primary-50 border-primary-200' }} hover:shadow-lg transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full 
                                {{ $notification->read_at ? 'bg-gray-100 text-gray-600' : 'bg-primary-100 text-primary-600' }}">
                                @php
                                    $type = $notification->data['type'] ?? 'info';
                                @endphp
                                @if($type === 'investment')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @elseif($type === 'withdrawal')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @elseif($type === 'support')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @elseif($type === 'profit')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-1">
                                    <p class="text-sm font-semibold {{ $notification->read_at ? 'text-gray-900' : 'text-primary-900' }}">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </p>
                                    @if(!$notification->read_at)
                                        <span class="badge badge-info flex-shrink-0">Nouveau</span>
                                    @endif
                                </div>
                                <p class="text-sm {{ $notification->read_at ? 'text-gray-600' : 'text-primary-800' }} mb-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->read_at)
                                        <span class="flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Lu {{ $notification->read_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                @if(isset($notification->data['action_url']))
                                    <div class="mt-3">
                                        <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center text-xs font-medium {{ $notification->read_at ? 'text-primary-600 hover:text-primary-700' : 'text-primary-700 hover:text-primary-800' }}">
                                            {{ $notification->data['action_text'] ?? 'Voir les détails' }}
                                            <svg class="ml-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="card text-center py-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Aucune notification</h3>
                <p class="mt-2 text-sm text-gray-600">Vous n'avez pas encore reçu de notifications.</p>
                <p class="mt-1 text-xs text-gray-500">Les notifications apparaîtront ici lorsque vous aurez des activités.</p>
            </div>
        @endif

        <!-- Info Banner -->
        <div class="mt-8 rounded-lg bg-blue-50 border border-blue-200 p-4">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">À propos des notifications</p>
                    <p class="mt-1 text-xs text-blue-800">
                        Vous recevrez des notifications pour les événements importants comme les confirmations d'investissement, 
                        les profits crédités, les mises à jour de retrait et les réponses du support.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-account-layout>