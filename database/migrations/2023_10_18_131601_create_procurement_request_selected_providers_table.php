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
        Schema::create('selected_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_request_id')->references('id')->on('procurement_requests', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('provider_id')->references('id')->on('providers', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('is_best_bidder')->default(0);
            $table->float('bidder_contract_price',12,2)->nullable();
            $table->float('bidder_revised_price',12,2)->nullable();
            $table->boolean('payment_status')->default(false);
            $table->date('date_paid')->nullable();
            $table->decimal('quality_rating', 5, 2)->nullable();
            $table->decimal('timeliness_rating', 5, 2)->nullable();
            $table->decimal('cost_rating', 5, 2)->nullable();
            $table->decimal('total_rating', 5, 2)->nullable();
            $table->longText('contracts_manager_comment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_request_selected_providers');
    }
};
