<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('settings')->where('key', 'whatsapp_number')->exists()) {
            DB::table('settings')->insert([
                'key'        => 'whatsapp_number',
                'value'      => '+13322830661',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'whatsapp_number')->delete();
    }
};
