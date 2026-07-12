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
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('min_amount', 15, 2)->default(10);
            $table->decimal('max_amount', 15, 2)->default(1000000);
            $table->enum('charge_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('charge_amount', 8, 2)->default(0);
            $table->string('duration')->default('Instant Payment');
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
        Schema::dropIfExists('withdrawal_methods');
    }
};
