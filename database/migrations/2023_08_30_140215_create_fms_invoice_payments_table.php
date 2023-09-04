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
        Schema::create('fms_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->references('id')->on('fms_invoices')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->string('payment_reference'); 
            $table->date('as_of'); 
            $table->double('payment_amount',16,2); 
            $table->double('payment_balance',16,2); 
            $table->tinyText('description')->nullable();
            $table->string('status')->default('Pending'); 
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
        Schema::dropIfExists('fms_invoice_payments');
    }
};
