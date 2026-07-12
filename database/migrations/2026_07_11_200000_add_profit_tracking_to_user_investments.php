<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_investments', function (Blueprint $table) {
            $table->decimal('accrued_profit', 15, 2)->default(0)->after('final_amount');
            $table->unsignedInteger('profit_periods_paid')->default(0)->after('accrued_profit');
            $table->date('last_profit_at')->nullable()->after('profit_periods_paid');
            $table->timestamp('matured_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('user_investments', function (Blueprint $table) {
            $table->dropColumn(['accrued_profit', 'profit_periods_paid', 'last_profit_at', 'matured_at']);
        });
    }
};
