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
                $table->string('read_only');
                $table->foreignId('type_id')->constrained()->nullable()->references('id')->on('fms_chart_of_accounts_types')->onDelete('restrict')->onUpdate('cascade');
                $table->string('description')->nullable();
                $table->integer('is_active')->default(1);
                $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
                $table->timestamps();
            });    
            DB::statement("INSERT INTO `fms_chart_of_accounts_sub_types` (`id`, `name`, `read_only`, `type_id`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
            (1, 'Current Asset', 'current_asset', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (2, 'Fixed Asset', 'fixed_asset', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (3, 'Inventory', 'inventory', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (4, 'Non-current Asset', 'non_current_asset', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (5, 'Prepayment', 'prepayment', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (6, 'Bank & Cash', 'bank_and_cash', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (7, 'Depreciation', 'depreciation', 1, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (8, 'Current Liability', 'current_liability', 2, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (9, 'Liability', 'liability', 2, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (10, 'Non-current Liability', 'non_current_liability', 2, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (11, 'Direct Costs', 'direct_costs', 3, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (12, 'Expense', 'expense', 3, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (13, 'Revenue', 'revenue', 4, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (14, 'Sales', 'sales', 4, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (15, 'Other Income', 'other_income', 4, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05'),
            (16, 'Equity', 'equity', 5, NULL, 1, NULL, '2022-12-05 21:47:05', '2022-12-05 21:47:05');
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
