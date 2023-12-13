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
        Schema::dropIfExists('fms_budget_lines');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_budget_lines', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');          
            $table->enum('type', ['Expense', 'Revenue']);          
            $table->foreignId('fms_budget_id')->references('id')->on('fms_budgets')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('chat_of_account')->nullable()->references('id')->on('fms_chart_of_accounts')->onDelete('restrict')->onUpdate('cascade');
            $table->double('allocated_amount',16,2)->default(0.00);
            $table->double('primary_balance',16,2)->default(0.00);
            $table->double('amount_held',16,2)->default(0.00);  
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
        Schema::dropIfExists('fms_budget_lines');
    }
};
