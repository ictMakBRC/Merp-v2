<?php

use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('dashboard', HumanResourceMainDashboardComponent::class)->name('human-resource-dashboard');
});
