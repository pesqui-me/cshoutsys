<x-account-layout title="Ticket Support">
    <main class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" @click="sidebarOpen = !sidebarOpen">☰</button>
                <a href="{{ route('user.support.index') }}" style="color: #6b7280; text-decoration: none; margin-right: 1rem;">← Retour</a>
                <h1 class="header-title">Ticket #{{ $ticket->reference }}</h1>
            </div>
            <div class="header-right">
                <span class="badge badge-{{ $ticket->status_color }}" style="padding: 0.75rem 1.5rem; font-size: 1rem;">
                    {{ $ticket->formatted_status }}
                </span>
            </div>
        </header>

        <div class="page-content">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <!-- Main Content -->
                <div>
                    <!-- Ticket Details Card -->
                    <div style="background: white; border-radius: 12px; padding: 2rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                            <div>
                                <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">{{ $ticket->subject }}</h2>
                                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                    <span style="font-size: 0.875rem; color: #6b7280;">
                                        📂 {{ ucfirst($ticket->category) }}
                                    </span>
                                    <span class="badge badge-{{ $ticket->priority }}" 
                                          style="padding: 0.25rem 0.75rem; font-size: 0.875rem; border-radius: 4px;
                                                 background: {{ $ticket->priority === 'high' ? '#fecaca' : ($ticket->priority === 'medium' ? '#fed7aa' : '#dbeafe') }};
                                                 color: {{ $ticket->priority === 'high' ? '#991b1b' : ($ticket->priority === 'medium' ? '#9a3412' : '#1e40af') }};">
                                        {{ $ticket->priority === 'high' ? '🔴 Urgent' : ($ticket->priority === 'medium' ? '🟡 Moyen' : '🟢 Faible') }}
                                    </span>
                                    <span style="font-size: 0.875rem; color: #6b7280;">
                                        📅 {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Original Message -->
                        <div style="background: #f9fafb; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #8b5cf6;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: #8b5cf6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                    {{ strtoupper(substr($ticket->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600;">{{ $ticket->user->name }}</p>
                                    <p style="margin: 0; font-size: 0.875rem; color: #6b7280;">{{ $ticket->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p style="margin: 0; line-height: 1.6; white-space: pre-wrap;">{{ $ticket->message }}</p>

                            @if($ticket->hasMedia('attachments'))
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                                    <p style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">📎 Pièces jointes:</p>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        @foreach($ticket->getMedia('attachments') as $attachment)
                                            <a href="{{ $attachment->getUrl() }}" 
                                               target="_blank"
                                               style="padding: 0.5rem 1rem; background: white; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; color: #1f2937; font-size: 0.875rem;">
                                                📄 {{ $attachment->file_name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Messages Thread -->
                    @if($messages->isNotEmpty())
                        <div style="background: white; border-radius: 12px; padding: 2rem; margin-bottom: 1.5rem;">
                            <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem;">💬 Conversation ({{ $messages->count() }} réponse(s))</h3>

                            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                                @foreach($messages as $message)
                                    @php
                                        $isFromSupport = $message->user->hasRole(['admin', 'super-admin', 'support']);
                                    @endphp

                                    <div style="display: flex; gap: 1rem; {{ $isFromSupport ? '' : 'flex-direction: row-reverse;' }}">
                                        <!-- Avatar -->
                                        <div style="width: 40px; height: 40px; border-radius: 50%; 
                                                   background: {{ $isFromSupport ? '#10b981' : '#8b5cf6' }}; 
                                                   color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; flex-shrink: 0;">
                                            {{ strtoupper(substr($message->user->name, 0, 2)) }}
                                        </div>

                                        <!-- Message Content -->
                                        <div style="flex: 1; max-width: 70%;">
                                            <div style="background: {{ $isFromSupport ? '#d1fae5' : '#f3f4f6' }}; 
                                                       padding: 1rem; border-radius: 12px; 
                                                       border-bottom-{{ $isFromSupport ? 'left' : 'right' }}-radius: 0;">
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                                    <p style="margin: 0; font-weight: 600; font-size: 0.875rem;">
                                                        {{ $isFromSupport ? '🎧 Support' : $message->user->name }}
                                                    </p>
                                                    <p style="margin: 0; font-size: 0.75rem; color: #6b7280;">
                                                        {{ $message->created_at->format('d/m H:i') }}
                                                    </p>
                                                </div>
                                                <p style="margin: 0; line-height: 1.6; white-space: pre-wrap;">{{ $message->message }}</p>

                                                @if($message->getFirstMediaUrl('attachments'))
                                                    <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(0,0,0,0.1);">
                                                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                                            @foreach($message->getMedia('attachments') as $attachment)
                                                                <a href="{{ $attachment->getUrl() }}" 
                                                                   target="_blank"
                                                                   style="padding: 0.25rem 0.75rem; background: white; border-radius: 4px; text-decoration: none; color: #1f2937; font-size: 0.75rem;">
                                                                    📄 {{ Str::limit($attachment->file_name, 20) }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Reply Form -->
                    @if($ticket->status !== 'closed')
                        <div style="background: white; border-radius: 12px; padding: 2rem;">
                            <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem;">💬 Répondre</h3>

                            <form method="POST" action="{{ route('user.support.reply', $ticket->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div style="margin-bottom: 1.5rem;">
                                    <textarea name="message" 
                                              required
                                              minlength="10"
                                              maxlength="5000"
                                              rows="6"
                                              placeholder="Votre message..."
                                              style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; resize: vertical;"></textarea>
                                </div>

                                <div style="margin-bottom: 1.5rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Pièces jointes (optionnel)</label>
                                    <input type="file" 
                                           name="attachments[]" 
                                           multiple
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px;">
                                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6b7280;">
                                        Max 3 fichiers, 5MB chacun
                                    </p>
                                </div>

                                <button type="submit" 
                                        style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                                    📤 Envoyer la réponse
                                </button>
                            </form>
                        </div>
                    @else
                        <div style="background: #f3f4f6; padding: 1.5rem; border-radius: 12px; text-align: center;">
                            <p style="margin: 0; color: #6b7280;">🔒 Ce ticket est fermé. Créez un nouveau ticket si vous avez besoin d'aide.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Info Card -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <h4 style="margin: 0 0 1rem 0; font-size: 1.125rem;">Informations</h4>
                        
                        <div style="margin-bottom: 0.75rem;">
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Référence</p>
                            <p style="margin: 0; font-weight: 600; font-family: monospace;">{{ $ticket->reference }}</p>
                        </div>

                        <div style="margin-bottom: 0.75rem;">
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Statut</p>
                            <span class="badge badge-{{ $ticket->status_color }}" style="padding: 0.5rem 1rem;">
                                {{ $ticket->formatted_status }}
                            </span>
                        </div>

                        <div style="margin-bottom: 0.75rem;">
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Catégorie</p>
                            <p style="margin: 0; font-weight: 600;">{{ ucfirst($ticket->category) }}</p>
                        </div>

                        <div style="margin-bottom: 0.75rem;">
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Priorité</p>
                            <p style="margin: 0; font-weight: 600;">
                                {{ $ticket->priority === 'high' ? '🔴 Urgent' : ($ticket->priority === 'medium' ? '🟡 Moyen' : '🟢 Faible') }}
                            </p>
                        </div>

                        <div style="margin-bottom: 0.75rem;">
                            <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Créé le</p>
                            <p style="margin: 0; font-weight: 600;">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($ticket->last_reply_at)
                            <div>
                                <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Dernière réponse</p>
                                <p style="margin: 0; font-weight: 600;">{{ $ticket->last_reply_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    @if($ticket->status === 'open')
                        <form method="POST" action="{{ route('user.support.close', $ticket->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir fermer ce ticket ?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                    style="width: 100%; padding: 1rem; background: #10b981; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-bottom: 1rem;">
                                ✅ Marquer comme résolu
                            </button>
                        </form>
                    @endif

                    <!-- Help Card -->
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; padding: 1.5rem;">
                        <h4 style="margin: 0 0 1rem 0;">💡 Délai de réponse</h4>
                        <p style="margin: 0; font-size: 0.875rem; opacity: 0.9;">
                            Notre équipe répond généralement sous 24 heures. Les tickets urgents sont traités en priorité.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-account-layout>