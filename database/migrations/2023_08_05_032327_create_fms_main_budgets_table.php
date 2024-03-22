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
            Schema::dropIfExists('fms_main_budgets');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Schema::create('fms_main_budgets', function (Blueprint $table) {
                $table->id();
                $table->string('name',200)->unique();             
                $table->string('code',16)->unique();             
                $table->double('estimated_income',16,2)->default(0.00);
                $table->double('estimated_expenditure',16,2)->default(0.00);            
                $table->foreignId('fiscal_year')->nullable()->references('id')->on('fms_financial_years')->constrained()->onUpdate('cascade')->onDelete('restrict');                 
                $table->foreignId('currency_id')->nullable();          
                $table->tinyText('description')->nullable();
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
        Schema::dropIfExists('fms_main_budgets');
    }
};
