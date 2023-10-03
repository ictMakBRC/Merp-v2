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
        Schema::dropIfExists('fms_payment_request_authorizations');
        Schema::create('fms_payment_request_authorizations', function (Blueprint $table) {
            $table->id();
            $table->integer('level');
            $table->foreignId('position')->references('id')->on('fms_payment_request_positions')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('approver_id')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->string('signature')->nullable();
            $table->date('signature_date')->nullable();
            $table->foreignId('request_id')->nullable()->references('id')->on('fms_payment_requests')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('request_code')->nullable()->references('request_code')->on('fms_payment_requests')->constrained();
            $table->enum('status',['Pending','Rejected','Active','Signed'])->default('Pending');
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
        Schema::dropIfExists('fms_payment_request_authorizations');
    }
};
