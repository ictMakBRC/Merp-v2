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
        Schema::table('fms_transactions', function (Blueprint $table) {
        $table->foreignId('invoice_id')->nullable()->constrained('fms_invoices','id')->onUpdate('cascade')->onDelete('restrict');    
        $table->foreignId('payment_id')->nullable()->constrained('fms_invoice_payments','id')->onUpdate('cascade')->onDelete('restrict'); 
        $table->foreignId('financial_year_id')->nullable()->constrained('fms_financial_years','id')->onUpdate('cascade')->onDelete('restrict'); 
        });
        Schema::table('fms_customers', function (Blueprint $table1) {
            $table1->string('type')->default('Customer')->after('name');    
        });
        Schema::table('fms_budgets', function (Blueprint $table2) {
            $table2->boolean('is_open')->default(0);   
            $table2->integer('adjusted')->default(0);   
            $table2->datetime('submitted_at')->nullable();   
            $table2->tinyText('comment')->nullable(); 
            $table2->foreignId('acknowledged_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table2->datetime('acknowledged_at')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
