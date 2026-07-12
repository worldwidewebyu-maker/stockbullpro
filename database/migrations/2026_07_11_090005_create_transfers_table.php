<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);        // what the recipient receives
            $table->decimal('charge', 15, 2)->default(0);
            $table->decimal('total', 15, 2);         // what the sender is debited (amount + charge)
            $table->enum('status', ['completed'])->default('completed');
            $table->timestamps();

            $table->index('sender_id');
            $table->index('recipient_id');
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('deposit','withdrawal','investment','profit','referral_bonus','bonus','adjustment','transfer') NOT NULL");
        }

        if (! DB::table('settings')->where('key', 'transfer_charge_percentage')->exists()) {
            DB::table('settings')->insert([
                'key'        => 'transfer_charge_percentage',
                'value'      => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('deposit','withdrawal','investment','profit','referral_bonus','bonus','adjustment') NOT NULL");
        }

        DB::table('settings')->where('key', 'transfer_charge_percentage')->delete();
    }
};
