<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'deposit', 'withdrawal', 'investment',
                'profit', 'referral_bonus', 'bonus', 'adjustment', 'transfer',
            ]);
            $table->enum('direction', ['credit', 'debit']);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['source_type', 'source_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
