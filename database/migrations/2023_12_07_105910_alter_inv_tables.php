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
        Schema::table('inv_requests', function (Blueprint $table) {
            $table->morphs('unitable');
            $table->morphs('loantable');
        });
        Schema::table('inv_department_items', function (Blueprint $table) {
            $table->morphs('unitable');
        });
        Schema::table('inv_stockcards', function (Blueprint $table) {
            $table->morphs('unitable');
        });
        Schema::table('inv_stock_documents', function (Blueprint $table) {
            $table->morphs('unitable');
        });
        Schema::table('inv_stock_settlements', function (Blueprint $table) {
            $table->morphs('unitable');
            $table->morphs('loantable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_stockcards', function (Blueprint $table) {
            //
        });
    }
};
