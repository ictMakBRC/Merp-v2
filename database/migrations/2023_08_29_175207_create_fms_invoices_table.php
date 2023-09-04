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
        Schema::create('fms_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('invoice_ref')->nullable();
            $table->date('invoice_date');
            $table->double('total_amount',16,2)->default(0.00);
            $table->double('total_paid',16,2)->default(0.00);
            $table->foreignId('invoice_from')->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('customer_id')->nullable()->references('id')->on('fms_customers')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('tax_id')->nullable(); 
            $table->foreignId('terms_id')->nullable(); 
            $table->tinyText('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->string('status')->default('Pending');
            $table->dateTime('reminder_sent_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_invoices');
    }
};
