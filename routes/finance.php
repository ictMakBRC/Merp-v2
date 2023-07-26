<?php

use App\Http\Livewire\Finance\Dashboard\FinanceMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'finance'], function () {
    Route::get('dashboard', FinanceMainDashboardComponent::class)->name('finance-dashboard');
});
