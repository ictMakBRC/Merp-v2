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
use App\Http\Livewire\Inventory\Requests\InvUnitRequestItemsComponent;
use App\Http\Livewire\Inventory\Requests\InvUnitRequestsComponent;
use App\Http\Livewire\Inventory\Requests\InvViewUnitRequestComponent;
use App\Http\Livewire\Inventory\Requisitions\ForecastsComponent;
use App\Http\Livewire\Inventory\Requisitions\GeneralRequisitionsComponent;
use App\Http\Livewire\Inventory\Requisitions\ConsumptionBasedRequisitionsComponent;
use App\Http\Livewire\Inventory\Stock\InvItemsStockStatusComponent;
use App\Http\Livewire\Inventory\Stock\InvStockHistoryComponent;
use App\Http\Livewire\Inventory\Stock\InvStockItemComponent;
use App\Http\Livewire\Inventory\Stock\InvViewItemStockCardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'inventory','middleware' => ['permission:access_inventory_module']], function () {



  Route::get('inventory-home', InvUnitOfMeasuresComponent::class)->name('inventory-home');

  Route::get('dashboard/{type}', InventoryMainDashboardComponent::class)->name('inventory-dashboard');

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

  Route::group(['prefix' => 'stock/manage','middleware' => ['permission:access_inventory_module']], function () {
    Route::get('stores/sections', InvStorageSectionsComponent::class)->name('inventory-sections');
    Route::get('stores/sections/bins', InvStorageSubSectionsComponent::class)->name('inventory-storage_bins');
    Route::get('unit_of_measures', InvUnitOfMeasuresComponent::class)->name('inventory-unit_of_measures');
    Route::get('documents/{type}', InvStockHistoryComponent::class)->name('inventory-stock_doc');
    Route::get('document/items/{code}', InvStockItemComponent::class)->name('inventory-stock_doc_items');
    Route::get('status/{type}', InvItemsStockStatusComponent::class)->name('inventory-stock_status');
    Route::get('stock_card/{id}', InvViewItemStockCardComponent::class)->name('inventory-stock_card');
  });

  Route::group(['prefix' => 'requisitions','middleware' => ['permission:access_department_request']], function () {
    Route::get('forecast', ForecastsComponent::class)->name('forecast');
    Route::get('general-requests', GeneralRequisitionsComponent::class)->name('general-requests');
    Route::get('incoming-requests', GeneralRequisitionsComponent::class)->name('incoming-requests');
    Route::get('consumption-based', ConsumptionBasedRequisitionsComponent::class)->name('consumption-based');
    Route::get('list/{type}', InvUnitRequestsComponent::class)->name('inventory-requests');
    Route::get('view/{code}', InvViewUnitRequestComponent::class)->name('inventory-request_view');
    Route::get('items/{code}', InvUnitRequestItemsComponent::class)->name('inventory-request_items');
  });

});
