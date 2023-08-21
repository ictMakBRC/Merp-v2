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
        Schema::create('formal_documents', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable');
            $table->string('document_category');
            $table->string('document_name');
            $table->string('document_path');
            $table->text('description')->nullable();
            $table->boolean('expires')->default(0);
            $table->date('expiry_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formal_documents');
    }
};
