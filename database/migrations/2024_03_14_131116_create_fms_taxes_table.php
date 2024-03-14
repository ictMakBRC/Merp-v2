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
        Schema::create('fms_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('rate',16,2);
            $table->timestamps();
        });
        Schema::table('fms_transactions', function (Blueprint $table) {
            $table->foreignId('tax_id')->nullable()->constrained('fms_taxes','id')->onUpdate('cascade')->onDelete('restrict')->after('rate');
        });
        Schema::table('fms_invoices', function (Blueprint $table) {
            $table->foreignId('fiscal_year')->nullable()->references('id')->on('fms_financial_years')->constrained()->onUpdate('cascade')->onDelete('restrict'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_taxes');
    }
};
