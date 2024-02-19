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
        Schema::create('asset_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('entry_type');
            $table->morphs('assetable');
            $table->foreignId('asset_category_id')->constrained('asset_categories', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('asset_name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('engraved_label')->nullable()->unique();
            $table->string('description')->nullable();
           
            $table->string('acquisition_type');
            $table->foreignId('procurement_request_id')->nullable()->constrained('procurement_requests', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->date('procurement_date')->nullable();
            // $table->string('procurement_type')->nullable();
            $table->string('invoice_number')->nullable();
            $table->float('cost',12,2)->nullable();
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('providers')->constrained()->onUpdate('cascade')->onDelete('restrict');

            $table->boolean('has_service_contract')->default(false);
            $table->date('service_contract_expiry_date')->nullable();
            $table->foreignId('service_provider')->nullable()->references('id')->on('providers')->constrained()->onUpdate('cascade')->onDelete('restrict');

            $table->text('warranty_details')->nullable();

            $table->integer('useful_years')->nullable();
            $table->string('depreciation_method')->nullable();
            $table->string('salvage_value')->nullable();

            $table->string('asset_condition');
            $table->string('operational_status');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_catalog');
    }
};
