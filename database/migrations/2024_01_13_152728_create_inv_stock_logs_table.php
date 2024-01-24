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
        Schema::create('inv_stock_logs', function (Blueprint $table) {
            $table->id();
            $table->string('entry_type',20)->default('Department');
            $table->foreignId('procurement_id')->nullable()->references('id')->on('procurement_requests')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('stock_code',20)->unique();
            $table->string('grn',50)->nullable();
            $table->string('delivery_no',50)->nullable();
            $table->string('lpo',50)->nullable();
            $table->date('date_added')->nullable();
            $table->enum('status',['Pending','Received','Viewed','Acknowledged'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('acknowledged_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->datetime('acknowledged_at')->nullable();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->morphs('unitable');          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_stock_logs');
    }
};
