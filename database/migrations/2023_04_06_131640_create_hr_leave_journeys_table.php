<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leave_journeys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->string('comment')->nullable();
            $table->integer('step_position');
            $table->boolean('is_current')->default(false);
            $table->string('staff_responsible'); //expressed in terms of administrative structure not individual staff
            $table->dateTime('completed_at')->nullable();
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
        Schema::dropIfExists('leave_balances');
    }
};
