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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code');
            $table->string('name');
            $table->foreignId('grant_id')->nullable()->constrained('grant_profiles', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('pi')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('co_pi')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('currency');
            $table->string('progress_status');
            $table->longText('project_summary')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
