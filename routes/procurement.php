<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Procurement\Settings\ProvidersComponent;
use App\Http\Livewire\Procurement\Requests\Md\MdPanelComponent;
use App\Http\Livewire\Procurement\Settings\ProviderProfileComponent;
use App\Http\Livewire\Procurement\Requests\ProcurementRequestComponent;
use App\Http\Livewire\Procurement\Requests\Stores\StoresPanelComponent;
use App\Http\Livewire\Procurement\Requests\Finance\FinancePanelComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementSubcategoriesComponent;
use App\Http\Livewire\Procurement\Dashboard\ProcurementMainDashboardComponent;
use App\Http\Livewire\Procurement\Requests\ContractsManager\ContractsManagerPanelComponent;
use App\Http\Livewire\Procurement\Requests\ContractsManager\ContractsManagerRequestManagementComponent;
use App\Http\Livewire\Procurement\Requests\ContractsManager\ContractsManagerRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\Finance\FinanceRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\Md\MdRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\ProcurementRequestDetailsComponent;
use App\Http\Livewire\Procurement\Requests\Operations\OperationsPanelComponent;
use App\Http\Livewire\Procurement\Requests\Operations\OperationsRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\Procurement\Inc\LpoComponent;
use App\Http\Livewire\Procurement\Requests\Procurement\ProcurementBidManagementComponent;
use App\Http\Livewire\Procurement\Requests\Procurement\ProcurementOfficePanelComponent;
use App\Http\Livewire\Procurement\Requests\Procurement\ProcurementRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\Supervisor\SupervisorPanelComponent;
use App\Http\Livewire\Procurement\Requests\Stores\StoresRequestManagementComponent;
use App\Http\Livewire\Procurement\Requests\Stores\StoresRequestViewComponent;
use App\Http\Livewire\Procurement\Requests\Supervisor\SupervisorRequestViewComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementCategorizationComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementCommitteesComponent;
use App\Http\Livewire\Procurement\Settings\ProcurementMethodComponent;

Route::group(['prefix' => 'procurement'], function () {
    Route::get('dashboard', ProcurementMainDashboardComponent::class)->name('procurement-dashboard');
    
    Route::get('request', ProcurementRequestComponent::class)->name('procurement-request');
    Route::get('request/{id}/details', ProcurementRequestDetailsComponent::class)->name('procurement-request-details');

    Route::get('supervisor', SupervisorPanelComponent::class)->name('procurement-supervisor-panel');
    Route::get('supervisor/request/{id}/details', SupervisorRequestViewComponent::class)->name('supervisor-procurement-request-details');

    Route::get('finance', FinancePanelComponent::class)->name('procurement-finance-panel');
    Route::get('finance/request/{id}/details', FinanceRequestViewComponent::class)->name('finance-procurement-request-details');

    Route::get('operations', OperationsPanelComponent::class)->name('procurement-operations-panel');
    Route::get('operations/request/{id}/details', OperationsRequestViewComponent::class)->name('operations-procurement-request-details');

    Route::get('md', MdPanelComponent::class)->name('procurement-md-panel');
    Route::get('md/request/{id}/details', MdRequestViewComponent::class)->name('md-procurement-request-details');

    Route::get('proc-dept', ProcurementOfficePanelComponent::class)->name('procurement-office-panel');
    Route::get('proc-dept/request/{id}/details', ProcurementRequestViewComponent::class)->name('proc-dept-request-details');
    Route::get('proc-dept/request/{id}/bid-mgt', ProcurementBidManagementComponent::class)->name('proc-dept-bid-mgt');
    Route::get('proc-dept/request/{id}/lpo', LpoComponent::class)->name('proc-lpo');
    

    Route::get('stores', StoresPanelComponent::class)->name('procurement-stores-panel');
    Route::get('stores/request/{id}/details', StoresRequestViewComponent::class)->name('stores-procurement-request-details');
    Route::get('stores/request/{id}/mgt', StoresRequestManagementComponent::class)->name('stores-request-mgt');

    Route::get('contracts-manager', ContractsManagerPanelComponent::class)->name('contracts-manager-panel');
    Route::get('contracts-manager/request/{id}/details', ContractsManagerRequestViewComponent::class)->name('contracts-manager-request-details');
    Route::get('contracts-manager/request/{id}/mgt', ContractsManagerRequestManagementComponent::class)->name('contracts-manager-request-mgt');
    

    Route::group(['prefix' => 'settings'], function () {
        
        Route::group(['prefix' => 'providers'], function () {
            Route::get('manage', ProvidersComponent::class)->name('manage-providers');
            Route::get('{id}/profile', ProviderProfileComponent::class)->name('provider-profile');
        });

        Route::group(['prefix' => 'sectors'], function () {
            Route::get('subcategories', ProcurementSubcategoriesComponent::class)->name('manage-subcategories');
        });

        Route::get('committees', ProcurementCommitteesComponent::class)->name('procurement-committees');
        Route::get('proc-methods', ProcurementMethodComponent::class)->name('procurement-methods');
        Route::get('proc-categorizations', ProcurementCategorizationComponent::class)->name('procurement-categorizations');
    });
});
