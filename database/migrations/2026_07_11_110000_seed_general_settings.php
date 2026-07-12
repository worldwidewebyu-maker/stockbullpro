<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'email_verification_enabled' => '1',
            'whatsapp_link'              => '',
            'support_email'              => 'info@stockbullpro.com',
        ];

        foreach ($defaults as $key => $value) {
            if (! DB::table('settings')->where('key', $key)->exists()) {
                DB::table('settings')->insert([
                    'key'        => $key,
                    'value'      => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'email_verification_enabled', 'whatsapp_link', 'support_email',
        ])->delete();
    }
};
