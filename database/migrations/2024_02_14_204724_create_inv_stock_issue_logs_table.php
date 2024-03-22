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
        Schema::create('inv_stock_issue_logs', function (Blueprint $table) {
            $table->id();            
            // $table->foreignId('inv_item_id')->constrained('inv_department_items','id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('batch_id')->nullable()->references('id')->on('inv_stock_log_items')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            // $table->foreignId('request_id')->nullable()->references('id')->on('inv_unit_requests')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('request_item_id')->nullable()->references('id')->on('inv_unit_request_items')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->decimal('qty_given');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_stock_issue_logs');
    }
};
