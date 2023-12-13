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
        Schema::create('fms_banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type',8)->default('Bank');
            $table->string('account_no')->unique(); 
            $table->date('as_of')->nullable(); 
            $table->boolean('is_active')->default(true);
            $table->double('current_balance',16,2)->default(0.00);             
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->text('notice_text')->nullable();
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
        Schema::dropIfExists('fms_banks');
    }
};
