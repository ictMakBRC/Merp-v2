<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inv_department_requests', function (Blueprint $table) {
          $table->unsignedBigInteger('approver_id')->after('department_id')->nullable();
          $table->foreign('approver_id')->references('id')->on('employees')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_department_requests', function (Blueprint $table) {
            //
        });
    }
};
