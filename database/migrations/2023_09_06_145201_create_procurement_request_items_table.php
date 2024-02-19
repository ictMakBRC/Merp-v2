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
        Schema::create('procurement_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_request_id')->constrained('procurement_requests', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->longText('description');
            $table->float('quantity',8,2);
            $table->string('unit_of_measure');
            $table->float('estimated_unit_cost',12,2);
            $table->float('total_cost',12,2);
            $table->boolean('received_status')->default(0);
            $table->float('quantity_delivered',8,2)->nullable();
            $table->string('condition')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_request_items');
    }
};
