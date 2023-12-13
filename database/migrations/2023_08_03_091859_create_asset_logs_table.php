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
        Schema::create('asset_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_catalog_id')->nullable()->constrained('asset_catalog', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('log_type');
            $table->date('date_allocated')->nullable();
            $table->foreignId('station_id')->nullable()->constrained('stations', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('department_id')->nullable()->constrained('departments', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('allocation_status')->nullable();

            $table->string('breakdown_number')->nullable()->unique();
            $table->string('breakdown_type')->nullable();
            $table->date('breakdown_date')->nullable();
            $table->string('breakdown_description')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('breakdown_status')->nullable();
           
            $table->unsignedBigInteger('asset_breakdown_id')->nullable();
            $table->string('service_type')->nullable();
            $table->date('date_serviced')->nullable();
            $table->text('service_action')->nullable();
            $table->text('service_recommendations')->nullable();
            $table->string('resolution_status')->nullable();
            $table->string('serviced_by')->nullable();
            $table->float('cost',12,2)->nullable();
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->date('next_service_date')->nullable();
            $table->foreignId('servicing_recorded_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
    
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_logs');
    }
};
