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
        Schema::create('fms_accounting_settings', function (Blueprint $table) {
            $table->id();
            $table->string('accounting_method',20)->default('Accrual');
            $table->string('first_month_fin_year',20)->default('January');
            $table->string('first_month_tax_year',20)->default('January');
            $table->string('home_currency',20)->default('UGX');
            $table->boolean('multicurrencyr')->default(true);
            $table->boolean('close_the_books')->default(false);
            $table->boolean('account_numbers')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_settings');
    }
};
