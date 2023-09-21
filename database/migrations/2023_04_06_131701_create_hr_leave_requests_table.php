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
        Schema::create('hr_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('leave_type_id')->nullable()->constrained('hr_leave_types', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('length')->nullable();
            $table->longText('reason')->nullable();
            $table->enum('status', ['APPROVED', 'PENDING', 'DECLINED'])->default('PENDING');
            $table->string('confirmation')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('leave_requests');
    }
};
