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
        Schema::create('inv_stockcards', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('commodity_id');
          $table->string('barcode', 100);
          $table->string('voucher_number', 100);
          $table->string('quantity', 100);
          $table->string('action', 100);
          $table->string('batch_number', 100)->nullable();
          $table->string('expiry_date', 100)->nullable();
          $table->string('received_date', 100)->nullable();
          $table->string('initials', 100);
          $table->string('remarks', 100)->nullable();
          $table->string('balance', 100)->nullable();
          $table->date('transaction_date');
          $table->string('quantity_in', 100)->nullable();
          $table->string('quantity_out', 100)->nullable();
          $table->integer('opening_balance')->nullable();
          $table->string('physical_count', 100)->nullable();
          $table->string('discrepancy', 100)->nullable();
          $table->unsignedBigInteger('created_by');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_stockcards');
    }
};
