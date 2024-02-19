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
        Schema::create('inv_stock_log_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_stock_log_id')->nullable()->constrained('inv_stock_logs','id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('inv_item_id')->constrained('inv_department_items','id')->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('stock_qty', 8, 2)->default(0);
            $table->decimal('qty_left', 20)->nullable()->default(0);
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->double('unit_cost', 60, 2)->nullable();
            $table->double('total_cost', 60, 2)->nullable();
            $table->foreignId('inv_store_id')->nullable()->constrained('inv_stores','id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('stock_code',20);
            $table->string('grn',50)->nullable();
            $table->enum('status',['Pending','Received','Viewed','Acknowledged'])->default('Received');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_stock_log_items');
    }
};
