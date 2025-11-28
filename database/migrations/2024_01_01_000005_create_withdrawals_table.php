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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference')->unique(); // Ex: WTH-2024-000001
            $table->decimal('amount', 10, 2);
            $table->decimal('fees', 10, 2)->default(0); // Frais éventuels
            $table->decimal('net_amount', 10, 2); // Montant net à recevoir
            $table->enum('status', [
                'pending', // En attente
                'under_review', // En cours de vérification
                'approved', // Approuvé
                'processing', // En cours de traitement
                'completed', // Complété
                'rejected', // Rejeté
                'cancelled' // Annulé
            ])->default('pending');
            $table->json('payment_details')->nullable(); // Adresse crypto, numéro de compte, etc.
            $table->text('user_notes')->nullable(); // Notes de l'utilisateur
            $table->text('admin_notes')->nullable(); // Notes administrateur
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['user_id', 'status']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};