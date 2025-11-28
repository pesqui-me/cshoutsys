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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_investment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference')->unique(); // Ex: TXN-2024-000001
            $table->enum('type', [
                'investment_purchase', // Achat de carte
                'profit_credit', // Crédit de gains
                'withdrawal', // Retrait
                'refund', // Remboursement
                'bonus', // Bonus
                'commission' // Commission
            ]);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->enum('status', [
                'pending', // En attente
                'processing', // En cours de traitement
                'completed', // Complété
                'failed', // Échoué
                'cancelled', // Annulé
                'refunded' // Remboursé
            ])->default('pending');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Données additionnelles (hash crypto, ID transaction, etc.)
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['user_id', 'type', 'status']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};