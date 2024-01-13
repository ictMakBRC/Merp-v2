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
        Schema::create('fms_request_employees', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('employee_id')->references('id')->on('employees')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('payroll_id')->nullable();
            $table->foreignId('payroll_rate_id')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->foreignId('currency_id')->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('amount', 16, 2);
            $table->foreignId('request_id')->nullable()->references('id')->on('fms_payment_requests')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('request_code')->nullable()->references('request_code')->on('fms_payment_requests')->constrained();
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Paid','Pending Payment'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');  
            $table->morphs('requestable');
            $table->morphs('contractable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_request_employees');
    }
};
