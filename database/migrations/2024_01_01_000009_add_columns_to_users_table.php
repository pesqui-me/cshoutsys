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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('country')->nullable()->after('phone');
            $table->decimal('balance', 10, 2)->default(0)->after('country'); // Solde total
            $table->decimal('total_invested', 10, 2)->default(0)->after('balance'); // Total investi
            $table->decimal('total_profit', 10, 2)->default(0)->after('total_invested'); // Total des gains
            $table->decimal('pending_profit', 10, 2)->default(0)->after('total_profit'); // Gains en attente
            $table->integer('active_investments')->default(0)->after('pending_profit'); // Nombre d'investissements actifs
            $table->boolean('is_active')->default(true)->after('active_investments');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->string('referral_code')->unique()->nullable()->after('last_login_at');
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null')->after('referral_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'country',
                'balance',
                'total_invested',
                'total_profit',
                'pending_profit',
                'active_investments',
                'is_active',
                'last_login_at',
                'referral_code',
                'referred_by'
            ]);
        });
    }
};