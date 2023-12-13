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
        Schema::dropIfExists('fms_budgets');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->unique();             
            $table->string('code',16)->unique();             
            $table->double('esitmated_income',16,2)->default(0.00);
            $table->double('estimated_expenditure',16,2)->default(0.00);            
            $table->foreignId('fiscal_year')->nullable()->references('id')->on('fms_financial_years')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('account_id')->nullable()->references('id')->on('fms_ledger_accounts')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->tinyText('description')->nullable();
            $table->morphs('requestable');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->string('status')->default('Pending');
            $table->boolean('is_active')->default(True);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_budgets');
    }
};
