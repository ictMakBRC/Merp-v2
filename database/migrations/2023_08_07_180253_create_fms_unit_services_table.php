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
        Schema::create('fms_unit_services', function (Blueprint $table) {
            $table->id();
            $table->float('cost_price',14,2)->default(0);
            $table->float('sale_price',14,2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->morphs('unitable');
            $table->foreignId('service_id')->nullable()->constrained('fms_services', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_unit_services');
    }
};
