<?php

use App\Http\Livewire\Documents\Dashboard\DocumentsMainDashboardComponent;
use App\Http\Livewire\Documents\Requests\DmSignatureRequestComponent;
use App\Http\Livewire\Documents\Requests\DmSignRequestDashboardComponent;
use App\Http\Livewire\Documents\Settings\DmCategoriesComponent;
use App\Http\Livewire\Documents\Settings\DmFoldersComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'documents'], function () {
    Route::get('dashboard', DocumentsMainDashboardComponent::class)->name('documents-dashboard');
    Route::group(['prefix' => 'settings'], function () {
        Route::get('folders', DmFoldersComponent::class)->name('documents-folders');
        Route::get('categories', DmCategoriesComponent::class)->name('documents-categories');
    });
    Route::group(['prefix' => 'requests'], function () {
        Route::get('dashboard', DmSignRequestDashboardComponent::class)->name('documents-request.dashboard');
        Route::get('outgoing', DmSignatureRequestComponent::class)->name('documents-request.out');
        Route::get('incoming', DmSignatureRequestComponent::class)->name('documents-request.in');
        Route::get('documents/sent', DmSignatureRequestComponent::class)->name('documents-request.sent');
        Route::get('documents/signed', DmSignatureRequestComponent::class)->name('documents-request.signed');
    });
});
