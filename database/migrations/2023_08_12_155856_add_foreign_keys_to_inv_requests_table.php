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
        Schema::table('inv_requests', function (Blueprint $table) {
            $table->foreign(['department_id'])->references(['id'])->on('departments');
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['acknowledged_by'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_requests', function (Blueprint $table) {
            $table->dropForeign('inv_requests_department_id_foreign');
            $table->dropForeign('inv_requests_user_id_foreign');
            $table->dropForeign('inv_requests_acknowledged_by_foreign');
        });
    }
};
