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
        Schema::create('fms_currency_updates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('currency_id')->constrained('fms_currencies')->onUpdate('cascade')->onDelete('restrict');
                $table->string('currency_code',50);
                $table->decimal('exchange_rate', 16, 2);
                $table->foreignId('created_by')->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
                $table->timestamps();
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_currency_updates');
    }
};
