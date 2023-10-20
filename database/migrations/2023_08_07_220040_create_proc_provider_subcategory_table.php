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
        Schema::create('provider_procurement_subcategory', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('provider_id')->references('id')->on('providers', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            // $table->foreignId('procurement_subcategory_id')->references('id')->on('procurement_subcategories', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_procurement_subcategory');
    }
};
