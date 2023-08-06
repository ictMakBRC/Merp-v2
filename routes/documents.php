<?php

use App\Http\Livewire\Documents\Dashboard\DocumentsMainDashboardComponent;
use App\Http\Livewire\Documents\Settings\DmCategoriesComponent;
use App\Http\Livewire\Documents\Settings\DmFoldersComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'documents'], function () {
    Route::get('dashboard', DocumentsMainDashboardComponent::class)->name('documents-dashboard');
    Route::group(['prefix' => 'settings'], function () {
        Route::get('folders', DmFoldersComponent::class)->name('documents-folders');
        Route::get('categories', DmCategoriesComponent::class)->name('documents-categories');
    });
});
