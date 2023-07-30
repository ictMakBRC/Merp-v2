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
        Schema::create('fms_chart_of_accounts_sub_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('type_id')->constrained()->nullable()->references('id')->on('fms_chart_of_accounts_types')->onDelete('restrict')->onUpdate('cascade');
                $table->string('description')->nullable();
                $table->integer('is_active')->default(1);
                $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
            });    
            DB::statement("INSERT INTO `fms_chart_of_accounts_sub_types` (`id`, `name`, `type_id`, `created_at`, `updated_at`) VALUES
            (1, 'Current Asset', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (2, 'Fixed Asset', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (3, 'Inventory', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (4, 'Non-current Asset', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (5, 'Prepayment', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (6, 'Bank & Cash', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (7, 'Depreciation', 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (8, 'Current Liability', 2, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (9, 'Liability', 2, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (10, 'Non-current Liability', 2, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (11, 'Direct Costs', 3, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (12, 'Expense', 3, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (13, 'Revenue', 4, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (14, 'Sales', 4, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (15, 'Other Income', 4, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
            (16, 'Equity', 5, '2022-12-05 16:47:05', '2022-12-05 16:47:05');
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_chart_of_accounts_sub_types');
    }
};
