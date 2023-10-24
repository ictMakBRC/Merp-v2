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
        Schema::create('procurement_categorizations', function (Blueprint $table) {
            $table->id();
            $table->string('categorization')->unique();
            $table->float('threshold',12,2);
            $table->float('contract_requirement_threshold',12,2)->nullable();
            $table->foreignId('currency_id')->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_categorizations');
    }
};
