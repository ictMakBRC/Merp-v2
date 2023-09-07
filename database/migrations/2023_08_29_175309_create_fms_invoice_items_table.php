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
        Schema::create('fms_invoice_items', function (Blueprint $table) {
            $table->id();           
            $table->foreignId('invoice_id')->nullable()->references('id')->on('fms_invoices')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('item_id')->nullable()->references('id')->on('fms_services')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('tax_id')->nullable(); 
            $table->double('quantity'); 
            $table->double('unit_price',16,2); 
            $table->double('line_total',16,2); 
            $table->tinyText('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_invoice_items');
    }
};
