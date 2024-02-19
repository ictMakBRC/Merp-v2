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
        Schema::create('fms_budget_adjustments', function (Blueprint $table) {
            $table->id();   
            $table->double('amount',16,2);
            $table->string('reason');
            $table->tinyText('description')->nullable();
            $table->enum('status',['Pending','Approved','Declined','Submitted'])->default('Pending');
            $table->tinyText('comment')->nullable();
            $table->foreignId('from_budget_line_id')->nullable()->references('id')->on('fms_budget_lines')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('to_budget_line_id')->nullable()->references('id')->on('fms_budget_lines')->constrained()->onUpdate('cascade')->onDelete('restrict');      
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
        Schema::dropIfExists('fms_budget_adjustments');
    }
};
