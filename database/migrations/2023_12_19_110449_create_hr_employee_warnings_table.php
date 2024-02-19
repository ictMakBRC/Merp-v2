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
        Schema::dropIfExists('hr_employee_warnings');
        Schema::create('hr_employee_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees','id')->onUpdate('cascade')->onDelete('restrict');   
            $table->json('tagged_employees')->nullable();
            $table->string('reason')->nullable();       
            $table->string('subject');    
            $table->text('letter');             
            $table->enum('status',['Pending','Submitted','Viewed','Closed'])->default('Pending');            
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
        Schema::dropIfExists('hr_employee_warnings');
    }
};
