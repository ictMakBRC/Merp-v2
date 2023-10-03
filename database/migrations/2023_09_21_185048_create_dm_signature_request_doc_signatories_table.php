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
        Schema::create('dm_signature_request_doc_signatories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->references('id')->on('dm_signature_request_docs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('signatory_id')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('signatory_level')->default(1);
            $table->string('title',50)->nullable();
            $table->text('summary')->nullable();
            $table->enum('status',['Pending','Declined','Signed','Active'])->default('Pending');
            $table->integer('is_active')->default(0);
            $table->boolean('acknowledgement')->default(false);
            $table->string('signature',15)->nullable();
            $table->string('signed_file')->nullable();
            $table->text('comments')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dm_signature_request_doc_signatories');
    }
};
