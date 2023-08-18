<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hr_pf_resignations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable()->index('resignations_employee_id_foreign');
            $table->unsignedBigInteger('department_id')->nullable()->index('resignations_department_id_foreign');
            $table->string('subject')->nullable();
            $table->date('hand_over_date')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_pf_resignation');
    }
};
