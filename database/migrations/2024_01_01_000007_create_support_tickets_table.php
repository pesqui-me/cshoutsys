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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique(); // Ex: TCK-2024-000001
            $table->string('subject');
            $table->enum('category', [
                'payment', // Paiement
                'technical', // Technique
                'account', // Compte
                'general' // Général
            ])->default('general');
            $table->enum('priority', [
                'low', // Basse
                'medium', // Moyenne
                'high' // Haute
            ])->default('medium');
            $table->enum('status', [
                'new', // Nouveau
                'open', // Ouvert
                'in_progress', // En cours
                'resolved', // Résolu
                'closed' // Fermé
            ])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
};