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
       
        // Schema::table('fms_budgets', function (Blueprint $table1) {
        //     $table1->double('rate')->default(1.00)->after('currency_id');
        //     $table1->double('estimated_income_local',16,2)->default(0.00)->after('estimated_income');
        //     $table1->double('estimated_expense_local',16,2)->default(0.00)->after('estimated_expenditure');
        // });
        // Schema::table('fms_invoices', function (Blueprint $table2) {
        //     $table2->double('rate')->default(1.00)->after('currency_id');
        //     $table2->double('amount_local',16,2)->default(1.00)->after('total_amount');
        // });
    }

    /**
     * Reverse the migrations.
     */
};
