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
        Schema::create('fms_payment_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference')->nullable();
            $table->string('file')->nullable();
            $table->foreignId('request_id')->nullable()->references('id')->on('fms_payment_requests')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('request_code')->nullable()->references('request_code')->on('fms_payment_requests')->constrained();
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
        Schema::dropIfExists('fms_payment_request_attachments');
    }
};
