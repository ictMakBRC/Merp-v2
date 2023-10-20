<?php

use App\Http\Livewire\Inventory\Dashboard\InventoryMainDashboardComponent;
use App\Http\Livewire\Inventory\Settings\InvCategoriesComponent;
use App\Http\Livewire\Inventory\Settings\InvStorageSectionsComponent;
use App\Http\Livewire\Inventory\Settings\InvStorageSubSectionsComponent;
use App\Http\Livewire\Inventory\Settings\InvStoresComponent;
use App\Http\Livewire\Inventory\Settings\InvUnitOfMeasuresComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'inventory'], function () {
    Route::get('dashboard', InventoryMainDashboardComponent::class)->name('inventory-dashboard');
    Route::group(['prefix' => 'settings'], function () {
        Route::get('categories', InvCategoriesComponent::class)->name('inventory-categories');
        Route::get('stores', InvStoresComponent::class)->name('inventory-stores');
        Route::get('stores/sections', InvStorageSectionsComponent::class)->name('inventory-sections');
        Route::get('stores/sections/bins', InvStorageSubSectionsComponent::class)->name('inventory-storage_bins');
        Route::get('unit_of_measures', InvUnitOfMeasuresComponent::class)->name('inventory-unit_of_measures');
    });
});
