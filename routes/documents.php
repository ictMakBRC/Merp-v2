<?php

use App\Http\Livewire\Documents\Dashboard\DocumentsMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'documents'], function () {
    Route::get('dashboard', DocumentsMainDashboardComponent::class)->name('documents-dashboard');
});
