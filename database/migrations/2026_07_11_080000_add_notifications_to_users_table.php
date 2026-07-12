<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notify_withdrawal_otp')->default(false)->after('referral');
            $table->boolean('notify_profit_email')->default(true)->after('notify_withdrawal_otp');
            $table->boolean('notify_plan_expiry_email')->default(true)->after('notify_profit_email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notify_withdrawal_otp', 'notify_profit_email', 'notify_plan_expiry_email']);
        });
    }
};
