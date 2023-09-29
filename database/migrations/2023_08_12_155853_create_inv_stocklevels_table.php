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
        Schema::create('inv_stocklevels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inv_items_id')->nullable()->index('inv_stocklevels_inv_items_id_foreign');
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_stocklevels_department_id_foreign');
            $table->double('stock_qty', 8, 2)->default(0);
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('stock_code')->nullable();
            $table->double('unit_cost ,60,2')->nullable();
            $table->double('total_cost ,60,2')->nullable();
            $table->unsignedBigInteger('inv_supplier_id')->nullable()->index('inv_stocklevels_inv_supplier_id_foreign');
            $table->unsignedBigInteger('inv_store_id')->nullable()->index('inv_stocklevels_inv_store_id_foreign');
            $table->string('grn')->nullable();
            $table->string('delivery_no')->nullable();
            $table->string('lpo')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('inv_stocklevels_user_id_foreign');
            $table->boolean('is_active')->default(false);
            $table->date('date_added')->nullable();
            $table->string('stock_year')->nullable();
            $table->string('stock_month')->nullable();
            $table->string('stock_week')->nullable();
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
        Schema::dropIfExists('inv_stocklevels');
    }
};
