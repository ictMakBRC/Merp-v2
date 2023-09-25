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
        Schema::create('dm_signature_request_docs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('document_code')->unique();
            $table->string('title');
            $table->string('original_file');
            $table->string('signed_file')->nullable();
            $table->string('request_code');
            $table->foreignId('category_id')->references('id')->on('dm_categories')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->foreignId('request_id')->references('id')->on('dm_signature_requests')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->boolean('is_active')->default(true);
            $table->enum('status',['Pending','Declined','Signed','Submitted'])->default('Pending');
            $table->integer('download_count')->default(0);
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
        Schema::dropIfExists('dm_signature_request_docs');
    }
};
