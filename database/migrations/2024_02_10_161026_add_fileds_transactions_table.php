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
        Schema::table('fms_transactions', function (Blueprint $table) {
            $table->decimal('bank_balance')->after('bank_id');
        });
        Schema::table('fms_banks', function (Blueprint $table) {
            $table->decimal('previous_balance')->after('current_balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_department_items');
    }
};
