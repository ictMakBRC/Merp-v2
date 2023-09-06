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
        Schema::table('inv_userdeparments', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['department_id'])->references(['id'])->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_userdeparments', function (Blueprint $table) {
            $table->dropForeign('inv_userdeparments_user_id_foreign');
            $table->dropForeign('inv_userdeparments_department_id_foreign');
        });
    }
};
