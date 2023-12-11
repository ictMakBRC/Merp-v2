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
        Schema::table('inv_stocklevels', function (Blueprint $table) {
            $table->foreign(['department_id'])->references(['id'])->on('departments');
            $table->foreign(['inv_items_id'])->references(['id'])->on('inv_department_items');
            $table->foreign(['inv_store_id'])->references(['id'])->on('inv_stores')->onUpdate('CASCADE');
            $table->foreign(['inv_supplier_id'])->references(['id'])->on('inv_suppliers')->onUpdate('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_stocklevels', function (Blueprint $table) {
            $table->dropForeign('inv_stocklevels_department_id_foreign');
            $table->dropForeign('inv_stocklevels_inv_items_id_foreign');
            $table->dropForeign('inv_stocklevels_inv_store_id_foreign');
            $table->dropForeign('inv_stocklevels_inv_supplier_id_foreign');
            $table->dropForeign('inv_stocklevels_user_id_foreign');
        });
    }
};
