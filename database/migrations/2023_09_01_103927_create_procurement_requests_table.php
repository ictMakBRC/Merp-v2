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
        Schema::disableForeignKeyConstraints();
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->string('request_type');
            $table->morphs('requestable');
            $table->text('subject');
            $table->longText('body');
            $table->text('procuring_entity_code')->nullable();
            $table->text('procurement_sector');
            $table->text('sequence_number')->nullable();
            $table->text('procurement_plan_ref')->nullable();
            $table->text('location_of_delivery');
            $table->date('date_required')->nullable();
            $table->float('contract_value',12,2)->default(0);
            $table->foreignId('budget_line_id')->nullable()->references('id')->on('fms_budget_lines', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('financial_year_id')->nullable()->references('id')->on('fms_financial_years', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('procurement_categorization_id')->nullable()->references('id')->on('procurement_categorizations', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('procurement_method_id')->nullable()->references('id')->on('procurement_methods', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('contracts_manager_id')->nullable()->references('id')->on('users', 'id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->date('bid_return_deadline')->nullable();
            $table->date('delivery_deadline')->nullable();
            $table->integer('step_order')->default(1);
            $table->string('status')->default('Draft');
            
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
