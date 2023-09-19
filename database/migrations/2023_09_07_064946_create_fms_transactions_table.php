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
        Schema::dropIfExists('fms_transactions');  
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_no')->unique();
            $table->string('trx_ref')->nullable();
            $table->date('trx_date');
            $table->double('total_amount',16,2)->default(0.00); 
            $table->double('rate')->default(1.00); 
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('billed_department')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('billed_project')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('customer_id')->nullable()->references('id')->on('fms_customers')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('budget_line_id')->nullable()->references('id')->on('fms_budget_lines')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('account_id')->nullable()->references('id')->on('fms_ledger_accounts')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->enum('trx_type',['Income','Expense'])->default('Expense');
            $table->enum('entry_type',['Internal','External','Invoice'])->default('External'); 
            $table->enum('status',['Paid','Pending','Approved','Canceled'])->default('Pending'); 
            $table->tinyText('description')->nullable();             
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('is_active')->default(True); 
            $table->boolean('is_department')->default(True); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_transactions');
    }
};
