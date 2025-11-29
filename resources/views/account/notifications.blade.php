<x-account-layout title="Notifications">
    <div class="mx-auto max-w-5xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="mt-2 text-sm text-gray-600">Restez informé de toutes vos activités</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-8">
            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Non lues</p>
                        <p class="mt-2 text-3xl font-bold text-primary-600">{{ $stats['unread'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 text-primary-600">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Lues</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ $stats['read'] }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Actions -->
        <div class="card mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Filters -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.profile.notifications') }}" 
                       class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-secondary' }}">
                        Toutes
                    </a>
                    <a href="{{ route('user.profile.notifications', ['filter' => 'unread']) }}" 
                       class="btn btn-sm {{ request('filter') === 'unread' ? 'btn-primary' : 'btn-secondary' }}">
                        Non lues
                        @if($unreadCount > 0)
                            <span class="ml-2 badge badge-danger">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('user.profile.notifications', ['filter' => 'read']) }}" 
                       class="btn btn-sm {{ request('filter') === 'read' ? 'btn-primary' : 'btn-secondary' }}">
                        Lues
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    @if($unreadCount > 0)
                        <form method="POST" action="{{ route('user.notifications.mark-all-read') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tout marquer comme lu
                            </button>
                        </form>
                    @endif

                    @if($stats['read'] > 0)
                        <form method="POST" 
                              action="{{ route('user.notifications.delete-all-read') }}" 
                              class="inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer toutes les notifications lues ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer les lues
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        @if($notifications->isNotEmpty())
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    <div class="card {{ $notification->is_read ? '' : 'bg-primary-50 border-primary-200' }} hover:shadow-lg transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full 
                                {{ $notification->is_read ? 'bg-gray-100 text-gray-600' : 'bg-primary-100 text-primary-600' }}">
                                @if($notification->type === 'investment')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @elseif($notification->type === 'withdrawal')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                @elseif($notification->type === 'support')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @elseif($notification->type === 'profit')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                @elseif($notification->type === 'success')
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($notification->type === 'warning')
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
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
                                    <p class="text-sm font-semibold {{ $notification->is_read ? 'text-gray-900' : 'text-primary-900' }}">
                                        {{ $notification->title }}
                                    </p>
                                    @if(!$notification->is_read)
                                        <span class="badge badge-info flex-shrink-0">Nouveau</span>
                                    @endif
                                </div>
                                <p class="text-sm {{ $notification->is_read ? 'text-gray-600' : 'text-primary-800' }} mb-2">
                                    {{ $notification->message }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if($notification->is_read)
                                            <span class="flex items-center gap-1">
                                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Lu {{ $notification->read_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Actions Buttons -->
                                    <div class="flex items-center gap-2">
                                        @if($notification->action_url)
                                            <a href="{{ route('user.notifications.mark-as-read', $notification->id) }}" 
                                               class="text-xs font-medium text-primary-600 hover:text-primary-700">
                                                Voir
                                            </a>
                                        @endif

                                        @if(!$notification->is_read)
                                            <form method="POST" action="{{ route('user.notifications.mark-as-read', $notification->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-xs font-medium text-green-600 hover:text-green-700"
                                                        title="Marquer comme lu">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" 
                                              action="{{ route('user.notifications.delete', $notification->id) }}" 
                                              class="inline"
                                              onsubmit="return confirm('Voulez-vous vraiment supprimer cette notification ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-xs font-medium text-red-600 hover:text-red-700"
                                                    title="Supprimer">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
                <h3 class="text-lg font-medium text-gray-900">
                    @if(request('filter') === 'unread')
                        Aucune notification non lue
                    @elseif(request('filter') === 'read')
                        Aucune notification lue
                    @else
                        Aucune notification
                    @endif
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    @if(request('filter'))
                        Aucune notification ne correspond à ce filtre.
                    @else
                        Vous n'avez pas encore reçu de notifications.
                    @endif
                </p>
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