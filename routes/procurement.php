<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Procurement\Store\StoresPanelComponent;
use App\Http\Livewire\Procurement\Settings\ProvidersComponent;
use App\Http\Livewire\Procurement\Settings\ProviderProfileComponent;
use App\Http\Livewire\Procurement\Requests\ProcurementRequestComponent;
use App\Http\Livewire\Procurement\Store\ProcurementItemsReceptionComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementSubcategoriesComponent;
use App\Http\Livewire\Procurement\Dashboard\ProcurementMainDashboardComponent;
use App\Http\Livewire\Procurement\Requests\FinancePanelComponent;
use App\Http\Livewire\Procurement\Requests\MdPanelComponent;
use App\Http\Livewire\Procurement\Requests\OperationsPanelComponent;
use App\Http\Livewire\Procurement\Requests\ProcurementRequestDetailsComponent;
use App\Http\Livewire\Procurement\Requests\SupervisorPanelComponent;

Route::group(['prefix' => 'procurement'], function () {
    Route::get('dashboard', ProcurementMainDashboardComponent::class)->name('procurement-dashboard');
    Route::get('request', ProcurementRequestComponent::class)->name('procurement-request');
    Route::get('stores-panel', StoresPanelComponent::class)->name('procurement-stores-panel');
    Route::get('supervisor-panel', SupervisorPanelComponent::class)->name('procurement-supervisor-panel');
    Route::get('finance-panel', FinancePanelComponent::class)->name('procurement-finance-panel');
    Route::get('operations-panel', OperationsPanelComponent::class)->name('procurement-operations-panel');
    Route::get('md-panel', MdPanelComponent::class)->name('procurement-md-panel');

    Route::get('request/{id}/items-reception', ProcurementItemsReceptionComponent::class)->name('procurement-items-reception');
    Route::get('request/{id}/details', ProcurementRequestDetailsComponent::class)->name('procurement-request-details');

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
