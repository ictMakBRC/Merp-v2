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
            $table->string('project_category');
            $table->string('project_type')->nullable();
            $table->unsignedBigInteger('associated_institution')->nullable();
            $table->string('project_code');
            $table->string('name');
            $table->foreignId('grant_id')->nullable()->constrained('grants', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('funding_source')->nullable();
            $table->decimal('funding_amount', 10, 2)->nullable();
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('pi')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('co_pi')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('project_summary')->nullable();
            $table->string('progress_status');
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
