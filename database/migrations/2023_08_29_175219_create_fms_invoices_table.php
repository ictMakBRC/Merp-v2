<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('fms_invoices');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_type',30)->default('External');
            $table->string('billed_by',60)->default('Department');
            $table->string('billed_to',60)->default('Customer');
            $table->enum('status',['Pending','Submitted','Reviewed','Approved', 'Acknowledged','Partially Paid','Fully Paid','Declined'])->default('Pending');
            $table->string('invoice_no', 50)->unique();
            $table->string('invoice_ref', 50)->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->double('total_amount',16,2)->default(0.00);
            $table->double('amount_local',16,2)->default(0.00);
            $table->double('total_paid',16,2)->default(0.00);   
            $table->double('adjustment',16,2)->default(0.00);    
            $table->enum('discount_type',['Percent','Fixed'])->default('Percent');   
            $table->double('discount_total',16,2)->default(0.00);   
            $table->double('discount',16,2)->default(0.00);     
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('billed_department')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('billed_project')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('customer_id')->nullable()->references('id')->on('fms_customers')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');             
            $table->double('rate')->default(1.00); 
            $table->foreignId('tax_id')->nullable(); 
            $table->foreignId('terms_id')->nullable(); 
            $table->tinyText('description')->nullable();
            $table->tinyText('customer_comment')->nullable();
            $table->tinyText('notes')->nullable();
            $table->integer('recurring')->default('0');
            $table->integer('custom_recurring')->nullable()->default('0');
            $table->string('recurring_type',10)->nullable();
            $table->integer('cycles')->nullable()->default(0);
            $table->integer('total_cycles')->nullable()->default(0);
            $table->dateTime('recurring_from')->nullable();
            $table->dateTime('recurring_to')->nullable();
            $table->dateTime('last_due_reminder')->default(now());
            $table->dateTime('last_overdue_reminder')->default(now());
            $table->integer('cancel_overdue_reminders')->default(0);
            $table->foreignId('reviewed_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('approved_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('acknowledged_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('paid_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->dateTime('approved_at')->nullable();   
            $table->dateTime('acknowledged_at')->nullable();   
            $table->dateTime('reviewed_at')->nullable();   
            $table->dateTime('paid_at')->nullable();   
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->morphs('requestable');
            $table->morphs('billtable');
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
