<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('investment_card_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique(); // Ex: INV-2024-000001
            $table->decimal('amount_paid', 10, 2); // Montant payé
            $table->decimal('expected_profit', 10, 2); // Gain attendu
            $table->decimal('actual_profit', 10, 2)->nullable(); // Gain réel (une fois traité)
            $table->enum('status', [
                'pending_payment', // En attente de paiement
                'payment_processing', // Paiement en cours de vérification
                'active', // Actif (compte à rebours lancé)
                'processing', // En cours de traitement
                'completed', // Complété (gains crédités)
                'cancelled', // Annulé
                'refunded' // Remboursé
            ])->default('pending_payment');
            $table->timestamp('purchased_at')->nullable(); // Date d'achat
            $table->timestamp('activated_at')->nullable(); // Date d'activation (début du compte à rebours)
            $table->timestamp('processing_starts_at')->nullable(); // Date de début du traitement
            $table->timestamp('completed_at')->nullable(); // Date de complétion
            $table->text('admin_notes')->nullable(); // Notes administrateur
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour les requêtes fréquentes
            $table->index(['user_id', 'status']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};