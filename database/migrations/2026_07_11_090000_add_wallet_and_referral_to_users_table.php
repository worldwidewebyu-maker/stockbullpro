<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 15, 2)->default(0)->after('password');
            $table->decimal('profit_total', 15, 2)->default(0)->after('balance');
            $table->decimal('bonus_total', 15, 2)->default(0)->after('profit_total');
            $table->decimal('referral_total', 15, 2)->default(0)->after('bonus_total');
            $table->string('referral_code')->nullable()->unique()->after('referral_total');
            $table->foreignId('referred_by')->nullable()->after('referral_code')
                ->constrained('users')->nullOnDelete();
            $table->boolean('is_admin')->default(false)->after('referred_by');
        });

        // Backfill a unique referral code for existing users.
        DB::table('users')->select('id')->orderBy('id')->each(function ($user) {
            do {
                $code = strtoupper(Str::random(8));
            } while (DB::table('users')->where('referral_code', $code)->exists());

            DB::table('users')->where('id', $user->id)->update(['referral_code' => $code]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referred_by');
            $table->dropColumn([
                'balance', 'profit_total', 'bonus_total', 'referral_total',
                'referral_code', 'is_admin',
            ]);
        });
    }
};
