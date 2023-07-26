<?php

use App\Http\Livewire\AssetsManagement\AssetsComponent;
use App\Http\Livewire\AssetsManagement\Dashboard\AssetsMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'assets'], function () {
    Route::get('dashboard', AssetsMainDashboardComponent::class)->name('assets-dashboard');
    Route::get('manage', AssetsComponent::class)->name('manage-assets');
});
