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
        Schema::create('inv_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sku')->unique();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('uom_id');
            $table->double('cost_price', 16, 2)->default(0.00);
            $table->double('max_qty', 8, 2)->default(0.00);
            $table->double('min_qty', 8, 2)->default(0.00);
            $table->string('description')->nullable();
            $table->string('expires')->default('No');
            $table->string('item_code')->nullable()->unique();
            $table->boolean('is_active')->default(True);
            $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('uom_id')->references('id')->on('inv_categories')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('category_id')->references('id')->on('inv_categories')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_items');
    }
};
