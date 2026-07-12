<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investment_plan_id')->constrained()->cascadeOnDelete();
            $table->string('plan_name');
            $table->decimal('roi_percentage', 10, 2);
            $table->string('roi_period');
            $table->unsignedInteger('duration_days');
            $table->decimal('amount', 15, 2);
            $table->decimal('charge', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'matured', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
