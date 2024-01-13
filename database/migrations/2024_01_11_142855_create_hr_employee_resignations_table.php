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
        Schema::create('hr_employee_resignations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees','id')->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('department_id')->nullable()->references('id')->on('departments')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('handover_to')->constrained('employees','id')->onUpdate('cascade')->onDelete('restrict');   
            $table->string('reason')->nullable();       
            $table->string('subject');  
            $table->string('contact',20);
            $table->string('email',90);
            $table->boolean('consent');   
            $table->integer('notice_period'); 
            $table->date('last_working_day');    
            $table->text('letter');             
            $table->enum('status',['Pending','Submitted','Viewed','Approved','Declined'])->default('Submitted');            
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('approved_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->datetime('approved_at')->nullable();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_employee_resignations');
    }
};
