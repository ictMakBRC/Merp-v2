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
        Schema::dropIfExists('fms_payroll_schedules');
        Schema::create('fms_payroll_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('payment_ref')->nullable();
            $table->date('payment_date')->nullable();
            $table->foreignId('employee_id')->references('id')->on('employees')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('fms_payroll_id')->references('id')->on('fms_payrolls')->constrained()->onUpdate('cascade')->onDelete('restrict');         
            $table->foreignId('currency_id')->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('rate')->default(1);
            $table->decimal('salary', 16, 2)->default(0.00);
            $table->decimal('base_salary', 16, 2)->default(0.00);
            $table->decimal('paye', 16, 2)->default(0.00);
            $table->decimal('worker_nssf', 16, 2)->default(0.00);
            $table->decimal('emp_nssf', 16, 2)->default(0.00);
            $table->decimal('deductions', 16, 2)->default(0.00);
            $table->decimal('bonuses', 16, 2)->default(0.00);
            $table->decimal('net_salary', 16, 2)->default(0.00);
            // $table->foreignId('request_id')->nullable()->references('id')->on('fms_payment_requests')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Paid','Completed'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');  
            $table->timestamps();
        });
        Schema::table('fms_request_employees', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->decimal('paye_rate', 16, 2)->default(0.00);
            $table->decimal('worker_nssf', 16, 2)->default(0.00);
            $table->decimal('emp_nssf', 16, 2)->default(0.00);
            $table->decimal('deductions', 16, 2)->default(0.00);
            $table->decimal('bonuses', 16, 2)->default(0.00);
            $table->decimal('net_salary', 16, 2)->default(0.00);  
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_payroll_schedules');
    }
};
