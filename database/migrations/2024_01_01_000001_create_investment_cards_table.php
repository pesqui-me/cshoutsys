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
        Schema::create('investment_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Carte 200$", "Carte 500$"
            $table->decimal('price', 10, 2); // Prix d'achat (200, 350, 500, 1000, 1500)
            $table->decimal('expected_profit', 10, 2); // Gain attendu
            $table->integer('roi_percentage'); // ROI en pourcentage (1600%, 2000%, etc.)
            $table->integer('processing_hours')->default(48); // Délai de traitement en heures
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true); // Carte disponible à l'achat
            $table->boolean('is_featured')->default(false); // Carte mise en avant
            $table->integer('order')->default(0); // Ordre d'affichage
            $table->json('features')->nullable(); // Caractéristiques additionnelles
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_cards');
    }
};