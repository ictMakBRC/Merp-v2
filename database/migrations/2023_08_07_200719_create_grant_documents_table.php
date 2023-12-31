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
        // Schema::create('grant_documents', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('grant_id')->constrained('grants', 'id')->onUpdate('cascade')->onDelete('restrict');
        //     $table->string('document_category');
        //     $table->boolean('expires')->default(0);
        //     $table->string('document_name');
        //     $table->string('document_path');
        //     $table->date('expiry_date')->nullable();
        //     $table->text('description')->nullable();
        //     $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grant_documents');
    }
};
