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
        Schema::create('inv_unit_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_requests_id')->nullable()->constrained('inv_unit_requests','id');
            $table->foreignId('inv_item_id')->constrained('inv_department_items','id')->onUpdate('cascade')->onDelete('restrict');
            $table->double('qty_requested', 8, 2)->default(0);
            $table->double('qty_given', 8, 2)->default(0);
            $table->string('request_code')->nullable();
            $table->boolean('is_active')->default(false);
            $table->enum('status',['Pending','Processed','Acknowledged'])->default('Pending');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_unit_request_items');
    }
};
