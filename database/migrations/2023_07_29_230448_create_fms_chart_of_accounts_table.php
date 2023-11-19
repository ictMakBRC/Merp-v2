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
            $table->integer('is_budget')->default(1);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->date('as_of')->nullable();
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement(" 
        INSERT INTO `fms_chart_of_accounts` (`id`, `name`, `code`, `parent_account`, `primary_balance`, `bank_balance`, `account_type`, `sub_account_type`, `is_active`, `description`, `created_by`, `as_of`, `created_at`, `updated_at`) VALUES
        (1, 'Accounts Receivable', '120', NULL, '0.000', '0.000', 1, 1, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (2, 'Computer Equipment', '160', NULL, '0.000', '0.000', 1, 2, 1, NULL, 1, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (3, 'Office Equipment', '150', NULL, '0.000', '0.000', 1, 2, 1, NULL, 1, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (4, 'Inventory', '140', NULL, '0.000', '0.000', 1, 3, 1, NULL, 1, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (5, 'Budget - Finance Staff', '857', NULL, '0.000', '0.000', 1, 6, 1, NULL, 1, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (6, 'Accumulated Depreciation', '170', NULL, '8000.000', '0.000', 1, 7, 1, 'soo good\n', NULL, '2023-07-28', '2022-12-05 13:47:05', '2023-07-31 18:27:28'),
        (7, 'Accounts Payable', '200', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (8, 'Accruals', '205', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (9, 'Office Equipment', '150', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (10, 'Clearing Account', '855', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (11, 'Employee Benefits Payable', '235', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (12, 'Employee Deductions payable', '236', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (13, 'Historical Adjustments', '255', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (14, 'Revenue Received in Advance', '835', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (15, 'Rounding', '260', NULL, '0.000', '0.000', 2, 8, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (16, 'Travel Expenses', '500', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 05:04:30'),
        (17, 'Training and Development Expenses', '600', NULL, '0.000', '0.000', 3, 12, 1, 'Good this', NULL, '2023-08-25', '2022-12-05 13:47:05', '2023-08-29 04:47:02'),
        (18, 'Transportation Expenses', '644', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 04:50:36'),
        (19, 'Salaries and Wages Expenses', '684', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 04:48:09'),
        (20, 'Employee Benefits Expenses', '810', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 04:48:48'),
        (21, 'General Office Expenses', '605', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 04:50:17'),
        (22, 'Consulting & Accounting', '615', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (23, 'Maintenance and Repairs Expenses', '700', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 04:49:41'),
        (24, 'General Expenses', '628', NULL, '0.000', '0.000', 3, 12, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (25, 'Interest Income', '460', NULL, '0.000', '0.000', 4, 13, 2, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (26, 'Other Revenue', '470', NULL, '0.000', '0.000', 4, 15, 1, NULL, NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 05:12:18'),
        (27, 'Purchase Discount', '475', NULL, '0.000', '0.000', 4, 13, 2, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (28, 'Service Sales', '400', NULL, '0.000', '0.000', 4, 13, 1, 'Service Sales', NULL, '2023-08-29', '2022-12-05 13:47:05', '2023-08-29 05:12:49'),
        (29, 'Common Stock', '330', NULL, '0.000', '0.000', 5, 16, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (30, 'Owners Contribution', '300', NULL, '0.000', '0.000', 5, 16, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (31, 'Owners Draw', '310', NULL, '0.000', '0.000', 5, 16, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (32, 'Retained Earnings', '320', NULL, '0.000', '0.000', 5, 16, 1, NULL, NULL, NULL, '2022-12-05 13:47:05', '2022-12-05 13:47:05'),
        (33, 'Salaries', '0', NULL, '7000.000', '0.000', 2, 8, 1, ',l', 1, '2023-07-07', '2023-07-31 17:58:45', '2023-08-29 04:15:49'),
        (34, 'Professional Services Expenses', '0', NULL, '0.000', '0.000', 3, 12, 1, 'Professional Services Expenses', 1, '2023-08-29', '2023-08-29 04:52:10', '2023-08-29 04:52:10'),
        (35, 'Memberships and Subscriptions Expenses', '0', NULL, '0.000', '0.000', 3, 12, 1, 'Memberships and Subscriptions Expenses', 1, '2023-08-29', '2023-08-29 04:52:47', '2023-08-29 04:52:47'),
        (36, 'Direct Materials Expenses', '0', NULL, '0.000', '0.000', 3, 11, 1, 'Direct Materials Expenses', 1, '2023-08-29', '2023-08-29 05:04:10', '2023-08-29 05:04:10'),
        (37, 'Direct Labor Costs', '0', NULL, '0.000', '0.000', 3, 11, 1, 'Direct Labour Costs', 1, '2023-08-29', '2023-08-29 05:09:23', '2023-08-29 05:09:23'),
        (38, 'Cash or Bank Accounts', '0', NULL, '0.000', '0.000', 1, 1, 1, 'Cash or Bank Accounts', 1, '2023-08-31', '2023-08-31 05:29:02', '2023-08-31 05:29:02'),
        (39, 'Software', '0', NULL, '0.000', '0.000', 4, 13, 1, 'software', 1, '2023-10-03', '2023-10-03 08:31:04', '2023-10-03 08:31:04');        
        ");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_chart_of_accounts');
    }
};
