<?php

use App\Http\Livewire\Procurement\Dashboard\ProcurementMainDashboardComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementSubcategoriesComponent;
use App\Http\Livewire\Procurement\Settings\ProviderProfileComponent;
use App\Http\Livewire\Procurement\Settings\ProvidersComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'procurement'], function () {
    Route::get('dashboard', ProcurementMainDashboardComponent::class)->name('procurement-dashboard');

    Route::group(['prefix' => 'settings'], function () {

        Route::group(['prefix' => 'providers'], function () {
            Route::get('manage', ProvidersComponent::class)->name('manage-providers');
            Route::get('{id}/profile', ProviderProfileComponent::class)->name('provider-profile');
        });

        Route::group(['prefix' => 'sectors'], function () {
            Route::get('subcategories', ProcurementSubcategoriesComponent::class)->name('manage-subcategories');
        });

    });
});
