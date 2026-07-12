<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('withdrawal_method_id')->constrained()->cascadeOnDelete();
            $table->string('wallet_address');
            $table->timestamps();

            $table->unique(['user_id', 'withdrawal_method_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wallets');
    }
};
