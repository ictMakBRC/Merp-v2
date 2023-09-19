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
        Schema::create('inv_stock_document_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inv_item_id')->nullable()->index('inv_stock_document_items_inv_item_id_foreign');
            $table->unsignedBigInteger('item_id')->nullable()->index('inv_stock_document_items_item_id_foreign');
            $table->double('stock_qty', 8, 2)->default(0);
            $table->decimal('qyt_remaining', 20)->nullable()->default(0);
            $table->decimal('qyt_given', 20)->nullable()->default(0);
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('date_added')->nullable();
            $table->string('stock_code');
            $table->unsignedBigInteger('document_id')->index('inv_stock_document_items_document_id_foreign');
            $table->double('unit_cost', 60, 2)->nullable();
            $table->double('total_cost', 60, 2)->nullable();
            $table->unsignedBigInteger('inv_supplier_id')->nullable()->index('inv_stock_document_items_inv_supplier_id_foreign');
            $table->unsignedBigInteger('inv_store_id')->nullable()->index('inv_stock_document_items_inv_store_id_foreign');
            $table->string('grn')->nullable();
            $table->string('delivery_no')->nullable();
            $table->string('lpo')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('inv_stock_document_items_user_id_foreign');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_stock_document_items_department_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stock_document_items');
    }
};
