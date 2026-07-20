<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('settings')->where('key', 'telegram_username')->exists()) {
            DB::table('settings')->insert([
                'key'        => 'telegram_username',
                'value'      => 'finxstockbullcomsupport',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'telegram_username')->delete();
    }
};
