<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('roi_percentage', 10, 2);
            $table->enum('roi_period', ['Daily', 'Weekly', 'Monthly'])->default('Daily');
            $table->unsignedInteger('duration_days');
            $table->decimal('min_amount', 15, 2);
            $table->decimal('max_amount', 15, 2);
            $table->enum('charge_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('charge_amount', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};
