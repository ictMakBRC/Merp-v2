<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->foreignId('asset_category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('asset_subcategory_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('barcode')->unique();
            $table->string('engraved_label')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('station_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('condition')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('purchase_price', 12, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->date('warranty_end')->nullable();
            $table->string('depreciation_method')->nullable();
            $table->float('depreciation_rate', 3, 2)->nullable();
            $table->integer('expected_useful_years')->nullable();
            $table->unsignedBigInteger('insurance_company')->nullable();
            $table->unsignedBigInteger('insurance_type')->nullable();
            $table->date('insurance_end')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
