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
        Schema::create('project_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->references('id')->on('designations')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('project_id')->references('id')->on('departments')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('contract_name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('fte', 12, 2)->nullable();
            $table->float('gross_salary', 12, 2)->nullable();
            $table->string('contract_file');
            $table->string('status')->default('Running');
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('project_contracts');
    }
};
