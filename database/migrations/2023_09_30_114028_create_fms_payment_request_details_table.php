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
        Schema::create('fms_payment_request_details', function (Blueprint $table) {
            $table->id();
            $table->string('expenditure');
            $table->tinyText('description')->nullable();
            $table->decimal('quantity');
            $table->decimal('unit_cost', 16, 2);
            $table->decimal('amount', 16, 2);
            $table->foreignId('request_id')->nullable()->references('id')->on('fms_payment_requests')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('request_code')->nullable()->references('request_code')->on('fms_payment_requests')->constrained();
            $table->enum('status',['Pending','Submitted','Rejected','Approved','Completed'])->default('Pending');            
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
        Schema::dropIfExists('fms_payment_request_details');
    }
};
