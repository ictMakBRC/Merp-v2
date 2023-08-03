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
        Schema::create('family_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('member_type');
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_name')->nullable();
            $table->string('member_status');
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('employer_contact')->nullable();
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
        Schema::dropIfExists('family_backgrounds');
    }
};
