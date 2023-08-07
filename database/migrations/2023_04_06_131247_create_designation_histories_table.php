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
        Schema::create('designation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('department_id')->nullable()->constrained('departments', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('station_id')->nullable()->constrained('stations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('from')->nullable()->constrained('designations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('to')->nullable()->constrained('designations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('supervisor')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('official_contract_id')->nullable()->constrained('official_contracts', 'id')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('designation_histories');
    }
};
