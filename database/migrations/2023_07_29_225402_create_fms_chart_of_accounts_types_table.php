<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fms_chart_of_accounts_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('is_active')->default(1);
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });
        DB::statement("
            INSERT INTO `fms_chart_of_accounts_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
            (1, 'Assets', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (2, 'Liabilities', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (3, 'Expenses', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (4, 'Income', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (5, 'Equity', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05');
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_chart_of_accounts_types');
    }
};
