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
            $table->foreignId('coa_id')->nullable()->constrained('fms_chart_of_accounts','id')->onUpdate('cascade')->onDelete('restrict')->after('trx_date');
            $table->decimal('bank_balance', 16,2)->nullable()->after('bank_id');
        });
        Schema::table('fms_banks', function (Blueprint $table) {
            $table->foreignId('coa_id')->nullable()->constrained('fms_chart_of_accounts','id')->onUpdate('cascade')->onDelete('restrict')->after('id');
            $table->decimal('previous_balance',16,2)->nullable()->after('current_balance')->default(0);
            $table->decimal('opening_balance',16,2)->nullable()->after('current_balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
};
