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
        Schema::table('inv_department_items', function (Blueprint $table) {
            // $table->foreign(['department_id'])->references(['id'])->on('departments');
            $table->foreign(['inv_item_id'])->references(['id'])->on('inv_items')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_department_items', function (Blueprint $table) {
            $table->dropForeign('inv_department_items_department_id_foreign');
            $table->dropForeign('inv_department_items_inv_item_id_foreign');
        });
    }
};
