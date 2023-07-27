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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('leave_id')->nullable()->constrained('leaves', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('length')->nullable();
            $table->longText('reason')->nullable();
            $table->longText('duties_delegated')->nullable();
            $table->string('status');
            $table->string('delegatee_status')->nullable();
            $table->string('confirmation')->nullable();
            $table->string('comment')->nullable();
            $table->string('delegatee_comment')->nullable();
            $table->foreignId('delegated_to')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('accepted_by')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
    
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
