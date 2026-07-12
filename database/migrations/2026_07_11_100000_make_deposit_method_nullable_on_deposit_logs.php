<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->dropForeign(['deposit_method_id']);
        });

        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->foreignId('deposit_method_id')->nullable()->change();
            $table->foreign('deposit_method_id')->references('id')->on('deposit_methods')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->dropForeign(['deposit_method_id']);
        });

        Schema::table('deposit_logs', function (Blueprint $table) {
            $table->foreignId('deposit_method_id')->nullable(false)->change();
            $table->foreign('deposit_method_id')->references('id')->on('deposit_methods')->cascadeOnDelete();
        });
    }
};
