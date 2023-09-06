<?php

use App\Http\Livewire\Finance\Accounting\ChartOfAccountsComponent;
use App\Http\Livewire\Finance\Budget\FmsBudgetLinesComponent;
use App\Http\Livewire\Finance\Budget\FmsBudgetsComponent;
use App\Http\Livewire\Finance\Budget\FmsViewBudgetComponent;
use App\Http\Livewire\Finance\Dashboard\FinanceMainDashboardComponent;
use App\Http\Livewire\Finance\Invoice\FmsInvoiceItemsComponent;
use App\Http\Livewire\Finance\Invoice\FmsInvoiceListsComponent;
use App\Http\Livewire\Finance\Invoice\FmsViewInvoiceComponent;
use App\Http\Livewire\Finance\Ledger\FmsLedgerAccountsComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsSubTypesComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsTypesComponent;
use App\Http\Livewire\Finance\Settings\CustomersComponent;
use App\Http\Livewire\Finance\Settings\FmsCurrencyComponent;
use App\Http\Livewire\Finance\Settings\FmsServiceCategoriesComponent;
use App\Http\Livewire\Finance\Settings\FmsServicesComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'finance'], function () {
    Route::get('dashboard', FinanceMainDashboardComponent::class)->name('finance-dashboard');

    Route::group(['prefix' => 'accounting'], function () {
        Route::get('chart-of-accounts', ChartOfAccountsComponent::class)->name('finance-chart_of_accounts');
        Route::get('ledger/accounts', FmsLedgerAccountsComponent::class)->name('finance-ledger_accounts');
        Route::get('budgets', FmsBudgetsComponent::class)->name('finance-budgets');
        Route::get('budgets/lines/{budget}', FmsBudgetLinesComponent::class)->name('finance-budget_lines');
        Route::get('budgets/view/{budget}', FmsViewBudgetComponent::class)->name('finance-budget_view');
        Route::get('invoices', FmsInvoiceListsComponent::class)->name('finance-invoices');
        Route::get('invoice/items/{inv_no}', FmsInvoiceItemsComponent::class)->name('finance-invoice_items');
        Route::get('invoice/view/{inv_no}', FmsViewInvoiceComponent::class)->name('finance-invoice_view');
        
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('chart-of-accounts/types', ChartOfAccountsTypesComponent::class)->name('finance-chart_of_account_types');
        Route::get('chart-of-accounts/subtypes', ChartOfAccountsSubTypesComponent::class)->name('finance-chart_of_account_sub_types');
        Route::get('customers', CustomersComponent::class)->name('finance-customers');
        Route::get('currencies', FmsCurrencyComponent::class)->name('finance-currencies');
        Route::get('categories', FmsServiceCategoriesComponent::class)->name('finance-categories');
        Route::get('services', FmsServicesComponent::class)->name('finance-services');
    });
});
