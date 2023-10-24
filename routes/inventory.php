<?php

use App\Http\Livewire\Inventory\Dashboard\InventoryMainDashboardComponent;
use App\Http\Livewire\Inventory\Item\InvItemsComponent;
use App\Http\Livewire\Inventory\Settings\InvCategoriesComponent;
use App\Http\Livewire\Inventory\Settings\InvStorageSectionsComponent;
use App\Http\Livewire\Inventory\Settings\InvStorageSubSectionsComponent;
use App\Http\Livewire\Inventory\Settings\InvStoresComponent;
use App\Http\Livewire\Inventory\Settings\InvUnitOfMeasuresComponent;
use App\Http\Livewire\Inventory\Settings\StoresComponent;
use App\Http\Livewire\Inventory\Settings\RejectionReasons;
use App\Http\Livewire\Inventory\Manage\CommoditiesComponent;
use App\Http\Livewire\Inventory\Manage\DepartmentItemsComponent;
use App\Http\Livewire\Inventory\Requisitions\ForecastsComponent;
use App\Http\Livewire\Inventory\Requisitions\GeneralRequisitionsComponent;
use App\Http\Livewire\Inventory\Requisitions\ConsumptionBasedRequisitionsComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'inventory','middleware' => ['permission:access_inventory_module']], function () {



  Route::get('inventory-home', InvUnitOfMeasuresComponent::class)->name('inventory-home');

  Route::get('dashboard', InventoryMainDashboardComponent::class)->name('inventory-dashboard');

  Route::group(['prefix' => 'manage','middleware' => ['permission:manage_inventory']], function () {
    Route::get('stores', InvStoresComponent::class)->name('inventory-stores');
    Route::get('rejection-reasons', RejectionReasons::class)->name('rejection-reasons');
    Route::get('categories', InvCategoriesComponent::class)->name('inventory-categories');
    Route::get('commodities', CommoditiesComponent::class)->name('inventory-commodities');
    Route::get('department-items', DepartmentItemsComponent::class)->name('department-items');
    // Route::get('stores/sections', InvStorageSectionsComponent::class)->name('inventory-sections');
    // Route::get('stores/sections/bins', InvStorageSubSectionsComponent::class)->name('inventory-storage_bins');
    // Route::get('unit_of_measures', InvUnitOfMeasuresComponent::class)->name('inventory-unit_of_measures');
  });

  Route::group(['prefix' => 'manage-stock','middleware' => ['permission:access_stock_management']], function () {
    Route::get('stores/sections', InvStorageSectionsComponent::class)->name('inventory-sections');
    Route::get('stores/sections/bins', InvStorageSubSectionsComponent::class)->name('inventory-storage_bins');
    Route::get('unit_of_measures', InvUnitOfMeasuresComponent::class)->name('inventory-unit_of_measures');
  });

  Route::group(['prefix' => 'requisitions','middleware' => ['permission:access_department_request']], function () {
    Route::get('forecast', ForecastsComponent::class)->name('forecast');
    Route::get('general-requests', GeneralRequisitionsComponent::class)->name('general-requests');
    Route::get('incoming-requests', GeneralRequisitionsComponent::class)->name('incoming-requests');
    Route::get('consumption-based', ConsumptionBasedRequisitionsComponent::class)->name('consumption-based');
  });

});
