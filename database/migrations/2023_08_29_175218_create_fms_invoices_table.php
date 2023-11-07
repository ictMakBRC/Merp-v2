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
            $table->string('invoice_no', 50)->unique();
            $table->string('invoice_ref', 50)->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->double('total_amount',16,2)->default(0.00);
            $table->double('total_paid',16,2)->default(0.00);   
            $table->double('adjustment',16,2)->default(0.00);  
            $table->enum('discount_type',['No Discount','Before Tax','After Tax'])->default('No Discount');  
            $table->enum('discount',['Percent','Fixed'])->default('Percent');   
            $table->double('discount_total',16,2)->default(0.00);   
            $table->double('discount_percent',16,2)->default(0.00);     
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('billed_department')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('billed_project')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('customer_id')->nullable()->references('id')->on('fms_customers')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('tax_id')->nullable(); 
            $table->foreignId('terms_id')->nullable(); 
            $table->tinyText('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->string('status')->default('Pending');
            $table->integer('recurring')->default('0');
            $table->integer('custom_recurring')->default('0');
            $table->string('recurring_type',10)->nullable();
            $table->integer('cycles')->default(0);
            $table->integer('total_cycles')->default(0);
            $table->dateTime('recurring_from')->nullable();
            $table->dateTime('recurring_to')->nullable();
            $table->dateTime('last_due_reminder')->default(now());
            $table->dateTime('last_overdue_reminder')->default(now());
            $table->integer('cancel_overdue_reminders')->default(0);
            $table->morphs('requestable');
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
