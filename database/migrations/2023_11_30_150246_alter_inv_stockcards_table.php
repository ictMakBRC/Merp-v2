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
        Schema::table('inv_stockcards', function (Blueprint $table) {
          $table->integer('batch_balance')->nullable()->after('batch_number');
          $table->unsignedBigInteger('storage_bin_id')->nullable()->after('commodity_id');
          $table->foreign('storage_bin_id')->references('id')->on('inv_storage_bins')->onDelete('RESTRICT');

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
