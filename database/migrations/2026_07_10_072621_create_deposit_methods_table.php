<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deposit_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wallet_address')->nullable();
            $table->string('qr_code')->nullable();       // stored path to uploaded QR image
            $table->string('network_type')->nullable();  // e.g. TRC20, ERC20
            $table->decimal('min_amount', 15, 2)->default(1);
            $table->decimal('max_amount', 15, 2)->default(1000000);
            $table->enum('charge_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('charge_amount', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_methods');
    }
};
