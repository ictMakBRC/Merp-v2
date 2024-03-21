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
        Schema::create('fms_invoice_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('invoice_id')->nullable()->references('id')->on('fms_invoices')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
            $table->timestamps();
        });

        Schema::table('fms_invoices', function (Blueprint $table) {
            $table->string('entry_type')->default('Department')->after('id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_invoice_attachments');
    }
};
