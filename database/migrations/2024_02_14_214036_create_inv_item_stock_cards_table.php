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
        Schema::create('inv_item_stock_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->nullable()->constrained('inv_stock_log_items','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('request_id')->nullable()->constrained('inv_unit_requests','id');
            $table->foreignId('inv_item_id')->constrained('inv_department_items','id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('voucher_number', 50);
            $table->decimal('quantity');
            $table->tinyText('comment')->nullable();
            $table->decimal('quantity_in')->nullable();
            $table->decimal('quantity_out')->nullable();
            $table->decimal('opening_balance')->nullable();
            $table->decimal('losses_adjustments')->nullable();
            $table->decimal('physical_count')->nullable();
            $table->decimal('discrepancy')->nullable();            
            $table->decimal('quantity_resolved')->nullable();            
            $table->decimal('batch_balance')->nullable();
            $table->decimal('item_balance')->nullable();
            $table->decimal('initial_quantity')->nullable();
            $table->string('transaction',100);
            $table->enum('transaction_type',['IN','OUT','LOSS','PC']);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_stock_cards');
    }
};
