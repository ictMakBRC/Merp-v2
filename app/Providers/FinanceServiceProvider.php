<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Finance\Settings\FmsFinancialYear;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
           // Fetch the active financial year (you can modify this query accordingly)
        $activeFinancialYear = FmsFinancialYear::where('is_budget_year', 1)->first();

        // Share the variable globally so it's available in all views
        View::share('activeFinancialYear', $activeFinancialYear);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
