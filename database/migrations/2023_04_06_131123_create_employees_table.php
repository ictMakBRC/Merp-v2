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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('entry_type');
            $table->string('employee_number')->unique();
            $table->string('nin_number')->nullable();
            $table->string('title');
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_name')->nullable();
            $table->string('gender');
            $table->string('nationality')->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('age');
            $table->string('birth_place')->nullable();
            $table->string('religious_affiliation')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_type')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->string('alt_email')->nullable()->unique();
            $table->string('contact');
            $table->string('alt_contact')->nullable();
            $table->foreignId('designation_id')->nullable()->constrained('designations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('station_id')->nullable()->constrained('stations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('department_id')->nullable()->constrained('departments', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('reporting_to')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');

            $table->string('work_type');
            $table->date('join_date')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('nssf_number')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('cv')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('employees');
    }
};
