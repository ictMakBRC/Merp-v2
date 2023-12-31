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
        Schema::table('inv-_notifications', function (Blueprint $table) {
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
        Schema::table('inv-_notifications', function (Blueprint $table) {
            $table->dropForeign('inv__notifications_department_id_foreign');
        });
    }
};
