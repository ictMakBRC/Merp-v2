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
        Schema::create('employee_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('project_id')->references('id')->on('projects', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('designation_id')->references('id')->on('designations')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->longText('contract_summary');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('fte', 12, 2)->nullable();
            $table->float('gross_salary', 12, 2)->nullable();
            $table->string('contract_file_path')->nullable();
            $table->string('status')->default('Running');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_project');
    }
};
