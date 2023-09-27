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
        Schema::create('inv_department_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_type')->nullable();
            $table->string('order_number');
            $table->unsignedBigInteger('ordered_by')->nullable();
            $table->string('email')->nullable();
            $table->date('order_date');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('item_type')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->date('date_required')->nullable();
            $table->decimal('total_consumption', 16, 2)->nullable();
            $table->decimal('total_received', 16, 2)->nullable();
            $table->decimal('opening_balance', 16, 2)->nullable();
            $table->decimal('losses_adjustments', 16, 2)->nullable();
            $table->decimal('total_closing_balance', 16, 2)->nullable();
            $table->decimal('max_stock_required', 16, 2)->nullable();
            $table->decimal('qty_to_order', 16, 2)->nullable();
            $table->decimal('quantity_required', 16, 2)->nullable();
            $table->string('comment', 500)->nullable();
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->date('date_received')->nullable();
            $table->decimal('quantity_dispatched', 16, 2)->nullable();
            $table->unsignedBigInteger('dispatched_by')->nullable();
            $table->date('dispatch_date')->nullable();
            $table->decimal('quantity_received_at_lab')->nullable();
            $table->string('reception_comment', 1000)->nullable();
            $table->string('dispatch_comment', 1000)->nullable();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('inv_items')->onDelete('cascade');
            $table->foreign('ordered_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dispatched_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_department_requests');
    }
};
