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
        Schema::create('fms_services', function (Blueprint $table) {
            $table->id();  
            $table->string('name')->unique();
            $table->string('sku')->unique();
            $table->string('code')->unique();
            $table->float('rate')->default(0);
            $table->boolean('is_taxable')->default(1);
            $table->float('tax_rate')->default(0);
            $table->boolean('is_purchased')->default(0);
            $table->foreignId('supplier_id')->nullable();
            $table->float('cost_price',14,2)->default(0);
            $table->float('sale_price',14,2)->default(0);
            $table->tinyText('description')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('fms_currencies', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('category_id')->nullable()->constrained('fms_service_categories', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('is_active')->default(True);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_services');
    }
};
