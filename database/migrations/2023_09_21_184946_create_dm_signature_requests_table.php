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
        Schema::create('dm_signature_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('request_code')->unique();
            $table->foreignId('category_id')->references('id')->on('dm_categories')->constrained()->onUpdate('cascade')->onDelete('restrict');   
            $table->enum('status',['Pending','Declined','Completed','Draft','Submitted'])->default('Pending');
            $table->enum('priority',['Urgent','Normal'])->default('Normal');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('dm_signature_requests');
    }
};
