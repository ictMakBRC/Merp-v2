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
          $table->renameColumn('remarks', 'comment');
          $table->integer('previous_balance')->nullable();
          $table->string('losses_adjustments')->nullable();
          $table->string('transaction_type');
          $table->string('to_from')->nullable();

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
