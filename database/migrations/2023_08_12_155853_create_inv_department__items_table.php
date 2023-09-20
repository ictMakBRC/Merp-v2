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
        Schema::create('inv_department_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_department_items_department_id_foreign');
            $table->unsignedBigInteger('inv_item_id')->nullable()->index('inv_department_items_inv_item_id_foreign');
            $table->integer('brand')->nullable();
            $table->boolean('is_active')->default(true);
            $table->double('qty_left', 8, 2)->default(0);
            $table->double('qty_held', 8, 2)->default(0);
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
        Schema::dropIfExists('inv_department_items');
    }
};
