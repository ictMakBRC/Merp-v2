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
        Schema::table('inv_requestitems', function (Blueprint $table) {
            $table->foreign(['inv_item_id'])->references(['id'])->on('inv_items');
            $table->foreign(['inv_items_id'])->references(['id'])->on('inv_department_items');
            $table->foreign(['inv_requests_id'])->references(['id'])->on('inv_requests')->onUpdate('CASCADE');
            $table->foreign(['users_id'])->references(['id'])->on('users')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_requestitems', function (Blueprint $table) {
            $table->dropForeign('inv_requestitems_inv_item_id_foreign');
            $table->dropForeign('inv_requestitems_inv_items_id_foreign');
            $table->dropForeign('inv_requestitems_inv_requests_id_foreign');
            $table->dropForeign('inv_requestitems_users_id_foreign');
        });
    }
};
