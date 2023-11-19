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
        Schema::create('inv_requestitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inv_requests_id')->nullable()->index('inv_requestitems_inv_requests_id_foreign');
            $table->unsignedBigInteger('inv_items_id')->nullable()->index('inv_requestitems_inv_items_id_foreign');
            $table->unsignedBigInteger('inv_item_id')->nullable()->index('inv_requestitems_inv_item_id_foreign');
            $table->double('request_qty', 8, 2)->default(0);
            $table->double('qty_given', 8, 2)->default(0);
            $table->string('request_code')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('item_state')->default('open');
            $table->unsignedBigInteger('users_id')->nullable()->index('inv_requestitems_users_id_foreign');
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
        Schema::dropIfExists('inv_requestitems');
    }
};
