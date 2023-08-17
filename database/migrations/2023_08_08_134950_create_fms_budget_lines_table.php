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
        Schema::create('fms_budget_lines', function (Blueprint $table) {
            $table->id();
            $table->string('code',50); 
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');  
            $table->foreignId('project_id')->nullable(); 
            $table->double('opening_balance',16,2);
            $table->double('current_balance',16,2);
            $table->date('as_of');
            $table->foreignId('account_id')->nullable()->references('id')->on('fms_ledger_sub_accounts')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('budget_year')->nullable()->references('id')->on('fms_financial_years')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->boolean('is_active')->default(True);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_budget_lines');
    }
};
