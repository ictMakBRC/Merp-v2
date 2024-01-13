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
        Schema::table('procurement_requests', function (Blueprint $table) {
            $table->integer('net_payment_terms')->nullable()->after('delivery_deadline');
            $table->string('lpo_no')->nullable()->after('net_payment_terms');
            $table->foreignId('lpo_prepared_by')->nullable()->after('lpo_no')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('lpo_checked_by')->nullable()->after('lpo_prepared_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('lpo_approved_by')->nullable()->after('lpo_checked_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
