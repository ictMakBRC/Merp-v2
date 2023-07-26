<?php

use App\Http\Livewire\Inventory\Dashboard\InventoryMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'inventory'], function () {
    Route::get('dashboard', InventoryMainDashboardComponent::class)->name('inventory-dashboard');
});
