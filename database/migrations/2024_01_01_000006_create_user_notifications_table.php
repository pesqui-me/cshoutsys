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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', [
                'info', // Information générale
                'success', // Succès
                'warning', // Avertissement
                'error', // Erreur
                'investment', // Lié aux investissements
                'payment', // Lié aux paiements
                'withdrawal', // Lié aux retraits
                'system' // Notification système
            ])->default('info');
            $table->string('icon')->nullable(); // Emoji ou classe d'icône
            $table->string('action_url')->nullable(); // Lien vers une page spécifique
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Index
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};