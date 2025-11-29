<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SupportTicket;
use App\Models\SupportMessage;

class SupportController extends Controller
{
    /**
     * Afficher la liste des tickets
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = SupportTicket::where('user_id', $user->id)
            ->with(['messages' => function($q) {
                $q->latest()->limit(1);
            }]);

        // Filtrer par statut
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filtrer par catégorie
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $tickets = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques
        $stats = [
            'total' => SupportTicket::where('user_id', $user->id)->count(),
            'new' => SupportTicket::where('user_id', $user->id)->where('status', 'new')->count(),
            'open' => SupportTicket::where('user_id', $user->id)->whereIn('status', ['open', 'in_progress'])->count(),
            'resolved' => SupportTicket::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        return view('account.support', compact('tickets', 'stats'));
    }

    /**
     * Afficher le formulaire de création de ticket
     */
    public function create()
    {
        return view('account.ticket-create');
    }

    /**
     * Créer un nouveau ticket
     */
    public function store(Request $request)
    {
        // ⭐ VALIDATION AMÉLIORÉE
        $validated = $request->validate([
            'subject' => 'required|string|min:5|max:255',
            'category' => 'required|in:payment,technical,account,general',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string|min:10|max:5000',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:5120', // 5MB max
        ], [
            // Messages en français
            'subject.required' => 'Le sujet est obligatoire.',
            'subject.min' => 'Le sujet doit contenir au moins 5 caractères.',
            'category.required' => 'Veuillez sélectionner une catégorie.',
            'priority.required' => 'Veuillez sélectionner une priorité.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'attachments.*.mimes' => 'Les fichiers doivent être des images, PDF ou documents Word.',
            'attachments.*.max' => 'Chaque fichier ne doit pas dépasser 5MB.',
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            // ⭐ LOG DE DEBUG
            Log::info('Creating support ticket', [
                'user_id' => $user->id,
                'subject' => $validated['subject'],
                'has_files' => $request->hasFile('attachments'),
                'files_count' => $request->hasFile('attachments') ? count($request->file('attachments')) : 0,
            ]);

            // Créer le ticket
            $ticket = SupportTicket::create([
                'user_id' => $user->id,
                'subject' => $validated['subject'],
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'status' => 'new',
            ]);

            Log::info('Support ticket created', ['ticket_id' => $ticket->id]);

            // Créer le premier message
            $message = SupportMessage::create([
                'support_ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'message' => $validated['message'],
                'is_admin_reply' => false,
            ]);

            Log::info('Support message created', ['message_id' => $message->id]);

            // Ajouter les pièces jointes au ticket
            if ($request->hasFile('attachments')) {
                $filesCount = 0;
                
                foreach ($request->file('attachments') as $file) {
                    try {
                        Log::info('Processing file', [
                            'filename' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                        ]);

                        $ticket->addMedia($file)
                            ->toMediaCollection('attachments');
                        
                        $filesCount++;
                        
                        Log::info('File attached successfully', [
                            'filename' => $file->getClientOriginalName(),
                        ]);

                    } catch (\Exception $fileException) {
                        // Si un fichier échoue, on continue avec les autres
                        Log::error('Failed to attach file', [
                            'filename' => $file->getClientOriginalName(),
                            'error' => $fileException->getMessage(),
                        ]);
                        
                        // ⭐ IMPORTANT : On ne rollback pas pour un fichier qui échoue
                        // throw $fileException;
                    }
                }

                Log::info('All files processed', ['attached_count' => $filesCount]);
            }

            DB::commit();

            Log::info('Support ticket transaction committed', ['ticket_id' => $ticket->id]);

            return redirect()
                ->route('user.support.index')
                ->with('success', 'Votre ticket a été créé avec succès ! Notre équipe vous répondra sous peu.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // ⭐ LOG DÉTAILLÉ DE L'ERREUR
            Log::error('Support ticket creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // ⭐ Message d'erreur détaillé en développement
            $errorMessage = config('app.debug') 
                ? 'Erreur : ' . $e->getMessage() . ' (Ligne ' . $e->getLine() . ')'
                : 'Une erreur est survenue lors de la création du ticket. Veuillez réessayer.';
            
            return back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    /**
     * Afficher les détails d'un ticket
     */
    public function show($id)
    {
        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['messages.user', 'assignedTo'])
            ->firstOrFail();

        // Charger les messages avec leurs auteurs
        $messages = $ticket->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('account.ticket-details', compact('ticket', 'messages'));
    }

    /**
     * Répondre à un ticket
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que le ticket n'est pas fermé
        if ($ticket->status === 'closed') {
            return back()->with('error', 'Ce ticket est fermé. Veuillez créer un nouveau ticket si nécessaire.');
        }

        DB::beginTransaction();

        try {
            // Créer le message
            $message = SupportMessage::create([
                'support_ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->message,
                'is_admin_reply' => false,
            ]);

            // Mettre à jour le statut du ticket si c'était "resolved"
            if ($ticket->status === 'resolved') {
                $ticket->update(['status' => 'open']);
            }

            DB::commit();

            return redirect()
                ->route('user.support.show', $ticket->id)
                ->with('success', 'Votre message a été envoyé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'envoi du message.');
        }
    }

    /**
     * Fermer un ticket
     */
    public function close($id)
    {
        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que le ticket peut être fermé
        if (in_array($ticket->status, ['resolved', 'closed'])) {
            $ticket->update(['status' => 'closed']);

            return redirect()
                ->route('user.support.index')
                ->with('success', 'Le ticket a été fermé.');
        }

        return back()->with('error', 'Ce ticket ne peut pas être fermé pour le moment.');
    }

    /**
     * Rouvrir un ticket fermé
     */
    public function reopen($id)
    {
        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que le ticket est fermé
        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);

            return redirect()
                ->route('user.support.show', $ticket->id)
                ->with('success', 'Le ticket a été réouvert.');
        }

        return back()->with('error', 'Ce ticket ne peut pas être réouvert.');
    }

    /**
     * Télécharger une pièce jointe
     */
    public function downloadAttachment($ticketId, $mediaId)
    {
        $ticket = SupportTicket::where('id', $ticketId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $media = $ticket->getMedia('attachments')->find($mediaId);

        if (!$media) {
            abort(404, 'Fichier introuvable.');
        }

        return response()->download($media->getPath(), $media->file_name);
    }
}