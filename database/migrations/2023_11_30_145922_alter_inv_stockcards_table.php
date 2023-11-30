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
          $table->string('barcode')->nullable()->change();
          $table->string('voucher_number')->nullable()->change();
          $table->decimal('balance', 16, 2)->nullable()->change();
          $table->decimal('quantity', 16, 2)->nullable()->change();
          $table->decimal('discrepancy', 16, 2)->nullable()->change();
          $table->decimal('quantity_in', 16, 2)->nullable()->change();
          $table->decimal('quantity_out', 16, 2)->nullable()->change();
          $table->decimal('opening_balance', 16, 2)->nullable()->change();

          $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
          $table->foreign('commodity_id')->references('id')->on('inv_items')->onDelete('cascade');
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
