<?php

use App\Http\Livewire\HumanResource\Admin\StationsComponent;
use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('stations', StationsComponent::class)->name('human-resource-stations');
});
