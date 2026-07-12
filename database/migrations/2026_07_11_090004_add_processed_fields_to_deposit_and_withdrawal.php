<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->foreignId('processed_by')->nullable()->after('approved_at')
                ->constrained('users')->nullOnDelete();
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->foreignId('processed_by')->nullable()->after('approved_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('processed_by');
            $table->dropColumn('approved_at');
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('processed_by');
            $table->dropColumn('approved_at');
        });
    }
};
