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
        Schema::create('fms_payroll_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate')->default(1);
            $table->foreignId('payroll_id')->references('id')->on('fms_payrolls')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('currency_id')->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('fms_payroll_rates');
    }
};
