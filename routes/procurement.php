<?php

use App\Http\Livewire\Procurement\Dashboard\ProcurementMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procurement'], function () {
    Route::get('dashboard', ProcurementMainDashboardComponent::class)->name('procurement-dashboard');
});
