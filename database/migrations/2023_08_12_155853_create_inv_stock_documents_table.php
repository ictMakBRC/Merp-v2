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
        Schema::create('inv_stock_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_stock_documents_department_id_foreign');
            $table->string('stock_code')->nullable();
            $table->string('grn')->nullable();
            $table->string('delivery_no')->nullable();
            $table->string('lpo')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('inv_stock_documents_user_id_foreign');
            $table->boolean('is_active')->default(false);
            $table->date('date_added')->nullable();
            $table->string('stock_year')->nullable();
            $table->string('stock_month')->nullable();
            $table->string('stock_week')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('acknowledged_by')->nullable()->index('inv_stock_documents_acknowledged_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_stock_documents');
    }
};
