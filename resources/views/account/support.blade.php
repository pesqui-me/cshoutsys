<x-account-layout title="Support">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Centre de Support</h1>
                <p class="mt-2 text-sm text-gray-600">Consultez vos tickets et obtenez de l'aide</p>
            </div>
            <a href="{{ route('user.support.create') }}" class="btn btn-primary">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouveau ticket
            </a>
        </div>

        <!-- Tickets List -->
        @if($tickets->isNotEmpty())
            <div class="space-y-4">
                @foreach($tickets as $ticket)
                    <div class="card hover:shadow-lg transition-shadow duration-200">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br 
                                    {{ $ticket->priority === 'high' ? 'from-red-500 to-red-600' : 
                                       ($ticket->priority === 'medium' ? 'from-yellow-500 to-yellow-600' : 'from-blue-500 to-blue-600') }} 
                                    text-white shadow-lg">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $ticket->subject }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">Réf: <span class="font-mono">{{ $ticket->reference }}</span></p>
                                    <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($ticket->message, 150) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="badge badge-{{ $ticket->status_color }}">
                                    {{ $ticket->formatted_status }}
                                </span>
                                @if($ticket->priority === 'high')
                                    <span class="badge badge-danger">
                                        Priorité haute
                                    </span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="badge badge-warning">
                                        Priorité moyenne
                                    </span>
                                @else
                                    <span class="badge badge-info">
                                        Priorité basse
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span>{{ ucfirst($ticket->category) }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                                @if($ticket->replies_count > 0)
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span>{{ $ticket->replies_count }} réponse(s)</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('user.support.show', $ticket) }}" class="btn btn-secondary btn-sm">
                                <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir le ticket
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun ticket</h3>
                <p class="mt-2 text-sm text-gray-600">Vous n'avez pas encore créé de ticket de support.</p>
                <div class="mt-6">
                    <a href="{{ route('user.support.create') }}" class="btn btn-primary">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer un ticket
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-account-layout>