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
        Schema::create('dm_signature_request_support_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->references('id')->on('dm_signature_request_docs')->onDelete('restrict')->onUpdate('cascade');
            $table->string('title');
            $table->string('original_file');
            $table->string('document_code')->unique();
            $table->foreignId('request_id')->nullable()->references('id')->on('dm_signature_requests')->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('is_active')->default(1);
            $table->integer('download_count')->default(0);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dm_signature_request_support_docs');
    }
};
