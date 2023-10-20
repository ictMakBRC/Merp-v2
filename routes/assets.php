<?php

use App\Http\Livewire\AssetsManagement\AssetsComponent;
use App\Http\Livewire\AssetsManagement\Dashboard\AssetsMainDashboardComponent;
use App\Http\Livewire\AssetsManagement\Settings\AssetCategoryComponent;
use App\Http\Livewire\AssetsManagement\Settings\AssetClassificationComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'assets'], function () {
    Route::get('dashboard', AssetsMainDashboardComponent::class)->name('asset-dashboard');
    Route::get('catalog', AssetsComponent::class)->name('asset-catalog');

    Route::group(['prefix' => 'settings'], function () {
        Route::get('classification', AssetClassificationComponent::class)->name('asset-classification');
        Route::get('category', AssetCategoryComponent::class)->name('asset-category');
    });
});
