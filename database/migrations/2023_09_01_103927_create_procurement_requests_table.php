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
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->string('request_type');
            $table->morphs('requestable');
            $table->text('subject');
            $table->longText('body');
            $table->text('procuring_entity_code')->nullable();
            $table->text('procurement_sector');
            $table->text('financial_year');
            $table->text('currency');
            $table->string('budget_line');
            $table->text('sequence_number')->nullable();
            $table->text('procurement_plan_ref')->nullable();
            $table->text('location_of_delivery');
            $table->date('date_required')->nullable();
            $table->float('contract_value',12,1)->nullable();
            // $table->foreignId('project_id')->nullable()->constrained('projects', 'id')->onUpdate('cascade')->onDelete('restrict');
            // $table->foreignId('department_id')->nullable()->constrained('departments', 'id')->onUpdate('cascade')->onDelete('restrict');
            
            $table->foreignId('approving_departmental_head')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('approving_accounting_head')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->string('status')->default('Draft');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
