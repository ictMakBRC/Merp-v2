<?php

use App\Http\Controllers\Documents\GeneralDocumentsController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Documents\Settings\DmFoldersComponent;
use App\Http\Livewire\Documents\Settings\DmCategoriesComponent;
use App\Http\Livewire\Documents\Requests\DmSignatureRequestComponent;
use App\Http\Livewire\Documents\Requests\DmSignRequestPreviewComponent;
use App\Http\Livewire\Documents\Requests\DmSignRequestSignDocComponent;
use App\Http\Livewire\Documents\Requests\DmSignRequestDashboardComponent;
use App\Http\Livewire\Documents\Dashboard\DocumentsMainDashboardComponent;
use App\Http\Livewire\Documents\Requests\DmSignRequestIncomingComponent;

Route::group(['prefix' => 'documents'], function () {
    Route::get('dashboard', DocumentsMainDashboardComponent::class)->name('documents-dashboard');
    Route::group(['prefix' => 'settings'], function () {
        Route::get('folders', DmFoldersComponent::class)->name('documents-folders');
        Route::get('categories', DmCategoriesComponent::class)->name('documents-categories');
    });
    Route::group(['prefix' => 'requests'], function () {
        Route::get('dashboard', DmSignRequestDashboardComponent::class)->name('documents-request.dashboard');
        Route::get('outgoing', DmSignatureRequestComponent::class)->name('documents-request.out');
        Route::get('sign/{code}', DmSignRequestSignDocComponent::class)->name('documents-request.sign');
        Route::get('incoming', DmSignRequestIncomingComponent::class)->name('documents-request.in');
        Route::get('documents/sent', DmSignatureRequestComponent::class)->name('documents-request.sent');
        Route::get('documents/signed', DmSignatureRequestComponent::class)->name('documents-request.signed');
        Route::get('documents/preview/{id}/signed', [GeneralDocumentsController::class,'previewSignedDoc'])->name('document.preview');
    });
});
