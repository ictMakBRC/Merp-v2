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
            $table->foreignId('procurement_categorization_id')->nullable()->references('id')->on('procurement_categorizations', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict')->after('procurement_categorization_id');
            $table->foreignId('procurement_method_id')->nullable()->references('id')->on('procurement_methods', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict')->after('procurement_categorization_id');
            $table->date('bid_return_deadline')->nullable()->after('procurement_method_id');
            $table->date('delivery_deadline')->nullable()->after('bid_return_deadline');
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
