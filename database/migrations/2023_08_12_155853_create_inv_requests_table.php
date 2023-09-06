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
        Schema::create('inv_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_code')->nullable();
            $table->string('request_type')->default('Internal');
            $table->unsignedBigInteger('department_id')->nullable()->index('inv_requests_department_id_foreign');
            $table->unsignedBigInteger('borrower_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('inv_requests_user_id_foreign');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->unsignedBigInteger('inventoryclerk_id')->nullable();
            $table->string('request_state')->default('open');
            $table->string('borrow_state')->default('na');
            $table->boolean('is_active')->default(false);
            $table->date('date_added')->nullable();
            $table->string('reqcomment')->nullable()->default('na');
            $table->date('date_approved')->nullable();
            $table->string('request_year')->nullable();
            $table->string('request_month')->nullable();
            $table->string('request_week')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('acknowledged_by')->nullable()->index('inv_requests_acknowledged_by_foreign');
            $table->string('acknowledgement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_requests');
    }
};
