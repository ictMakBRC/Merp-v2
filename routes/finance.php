<?php

use App\Http\Livewire\Finance\Accounting\ChartOfAccountsComponent;
use App\Http\Livewire\Finance\Dashboard\FinanceMainDashboardComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsSubTypesComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsTypesComponent;
use App\Http\Livewire\Finance\Settings\CustomersComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'finance'], function () {
    Route::get('dashboard', FinanceMainDashboardComponent::class)->name('finance-dashboard');

    Route::group(['prefix' => 'accounting'], function () {
        Route::get('chart-of-accounts', ChartOfAccountsComponent::class)->name('finance-chart_of_accounts');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('chart-of-accounts/types', ChartOfAccountsTypesComponent::class)->name('finance-chart_of_account_types');
        Route::get('chart-of-accounts/subtypes', ChartOfAccountsSubTypesComponent::class)->name('finance-chart_of_account_sub_types');
        Route::get('chart-of-accounts/customers', CustomersComponent::class)->name('finance-customers');
    });
});
