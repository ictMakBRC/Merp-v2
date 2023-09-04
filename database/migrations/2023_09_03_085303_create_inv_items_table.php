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
            $table->foreignId('category_id')->nullable()->constrained('inv_categories','id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('uom_id')->nullable()->constrained('inv_unit_of_measures', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->double('cost_price', 16, 2)->default(0.00);
            $table->double('max_qty', 8, 2)->default(0.00);
            $table->double('min_qty', 8, 2)->default(0.00);
            $table->string('description')->nullable();
            $table->string('expires')->default('No');
            $table->string('item_code')->nullable()->unique(); 
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('is_active')->default(True);
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
