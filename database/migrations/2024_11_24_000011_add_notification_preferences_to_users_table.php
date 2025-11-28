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
            // Préférences générales de notifications
            $table->boolean('email_notifications')->default(true)->after('remember_token');
            $table->boolean('sms_notifications')->default(false)->after('email_notifications');
            
            // Préférences par type de notification
            $table->boolean('investment_notifications')->default(true)->after('sms_notifications');
            $table->boolean('withdrawal_notifications')->default(true)->after('investment_notifications');
            $table->boolean('promotion_notifications')->default(true)->after('withdrawal_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_notifications',
                'sms_notifications',
                'investment_notifications',
                'withdrawal_notifications',
                'promotion_notifications',
            ]);
        });
    }
};