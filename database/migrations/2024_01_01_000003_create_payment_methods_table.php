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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Bitcoin", "Perfect Money", "Mobile Money"
            $table->string('slug')->unique(); // Ex: "bitcoin", "perfect-money"
            $table->string('type'); // crypto, e-wallet, mobile-money, bank-transfer
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // Configuration spécifique (adresses, API keys, etc.)
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};