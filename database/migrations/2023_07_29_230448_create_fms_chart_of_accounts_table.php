<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fms_chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->default(0);
            $table->foreignId('parent_account')->nullable();
            $table->decimal('primary_balance', 60, 3)->default(0);
            $table->decimal('bank_balance', 60, 3)->default(0);
            $table->foreignId('account_type')->nullable()->references('id')->on('fms_chart_of_accounts_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('sub_account_type')->nullable()->references('id')->on('fms_chart_of_accounts_sub_types')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('is_active')->default(1);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->date('as_of')->nullable();
            $table->timestamps();
        });

        // DB::statement(" INSERT INTO `fms_chart_of_accounts` (`id`, `name`, `code`, `account_type`, `sub_account_type`, `is_active`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
        //     (1, 'Accounts Receivable', 120, 1, 1, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (2, 'Computer Equipment', 160, 1, 2, 1, NULL, 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (3, 'Office Equipment', 150, 1, 2, 1, NULL, 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (4, 'Inventory', 140, 1, 3, 1, NULL, 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (5, 'Budget - Finance Staff', 857, 1, 6, 1, NULL, 1, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (6, 'Accumulated Depreciation', 170, 1, 7, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (7, 'Accounts Payable', 200, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (8, 'Accruals', 205, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (9, 'Office Equipment', 150, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (10, 'Clearing Account', 855, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (11, 'Employee Benefits Payable', 235, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (12, 'Employee Deductions payable', 236, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (13, 'Historical Adjustments', 255, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (14, 'Revenue Received in Advance', 835, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (15, 'Rounding', 260, 2, 8, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (16, 'Costs of Goods Sold', 500, 3, 11, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (17, 'Advertising', 600, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (18, 'Automobile Expenses', 644, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (19, 'Bad Debts', 684, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (20, 'Bank Revaluations', 810, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (21, 'Bank Service Charges', 605, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (22, 'Consulting & Accounting', 615, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (23, 'Depreciation', 700, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (24, 'General Expenses', 628, 3, 12, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (25, 'Interest Income', 460, 4, 13, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (26, 'Other Revenue', 470, 4, 13, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (27, 'Purchase Discount', 475, 4, 13, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (28, 'Sales', 400, 4, 13, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (29, 'Common Stock', 330, 5, 16, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (30, 'Owners Contribution', 300, 5, 16, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (31, 'Owners Draw', 310, 5, 16, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05'),
        //     (32, 'Retained Earnings', 320, 5, 16, 1, NULL, NULL, '2022-12-05 16:47:05', '2022-12-05 16:47:05');
        //     ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_chart_of_accounts');
    }
};
