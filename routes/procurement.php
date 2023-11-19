<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Procurement\Settings\ProvidersComponent;
use App\Http\Livewire\Procurement\Settings\ProviderProfileComponent;
use App\Http\Livewire\Procurement\Requests\ProcurementRequestComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementSubcategoriesComponent;
use App\Http\Livewire\Procurement\Dashboard\ProcurementMainDashboardComponent;
use App\Http\Livewire\Procurement\Store\ProcurementItemsReceptionComponent;
use App\Http\Livewire\Procurement\Store\StoresPanelComponent;

Route::group(['prefix' => 'procurement'], function () {
    Route::get('dashboard', ProcurementMainDashboardComponent::class)->name('procurement-dashboard');
    Route::get('request', ProcurementRequestComponent::class)->name('procurement-request');
    Route::get('stores', StoresPanelComponent::class)->name('procurement-stores-panel');
    Route::get('request/{id}/items-reception', ProcurementItemsReceptionComponent::class)->name('procurement-items-reception');

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
