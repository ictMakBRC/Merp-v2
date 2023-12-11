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
        Schema::create('fms_unit_budget_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['Revenue', 'Expense']);
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('account_id')->nullable()->references('id')->on('fms_chart_of_accounts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');             
            $table->tinyText('description')->nullable();
            $table->integer('is_active')->default(1);
            $table->morphs('requestable');
            $table->timestamps();
        });
        Schema::table('fms_budget_lines', function (Blueprint $table) {         
          $table->foreignId('line_id')->nullable()->references('id')->on('fms_unit_budget_lines')->onDelete('restrict')->onUpdate('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_unit_budget_lines');
    }
};
