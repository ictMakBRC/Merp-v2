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
        Schema::create('inv_stock_settlements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_code')->nullable();
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_stock_settlements_department_id_foreign');
            $table->unsignedBigInteger('borrower_id')->nullable()->index('inv_stock_settlements_borrower_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('inv_stock_settlements_user_id_foreign');
            $table->unsignedBigInteger('qty_given')->nullable();
            $table->unsignedBigInteger('qty_remaining')->nullable();
            $table->date('date_added')->nullable();
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
        Schema::dropIfExists('inv_stock_settlements');
    }
};
