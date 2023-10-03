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
        Schema::dropIfExists('fms_payment_requests');
        Schema::create('fms_payment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_description');
            $table->string('request_type',70);
            $table->string('request_code',20)->unique();
            $table->decimal('total_amount', 16, 2);
            $table->string('amount_in_words');
            $table->string('requester_signature',50)->nullable();
            $table->date('date_submitted')->nullable(); 
            $table->date('date_approved')->nullable(); 
            $table->double('rate')->default(1.00);             
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->text('notice_text')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments','id')->onUpdate('cascade')->onDelete('restrict');    
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onUpdate('cascade')->onDelete('restrict'); 
            $table->foreignId('budget_line_id')->nullable()->references('id')->on('fms_budget_lines')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('from_account')->nullable()->references('id')->on('fms_ledger_accounts')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Completed'])->default('Pending');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');             
            $table->morphs('requestable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_payment_requests');
    }
};
