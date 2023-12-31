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
        Schema::dropIfExists('fms_payroll_data');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('fms_payroll_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('fms_payroll_id')->references('id')->on('fms_payrolls')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('payroll_rate_id')->references('id')->on('fms_payroll_rates')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('payment_ref',70)->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->foreignId('currency_id')->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('rate')->default(1);
            $table->decimal('salary', 16, 2)->default(0.00);
            $table->decimal('base_salary', 16, 2)->default(0.00);
            $table->decimal('deductions', 16, 2)->default(0.00);
            $table->decimal('employee_nssf', 16, 2)->default(0.00);
            $table->decimal('employer_nssf', 16, 2)->default(0.00);
            $table->decimal('other_deductions', 16, 2)->default(0.00);
            $table->tinyText('deduction_description')->nullable();
            $table->decimal('bonuses', 16, 2)->default(0.00);
            $table->decimal('net_salary', 16, 2)->default(0.00);
            $table->foreignId('request_id')->nullable()->references('id')->on('fms_request_employees')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Pending Payment','Paid','Completed'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');  
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_payroll_data');
    }
};
