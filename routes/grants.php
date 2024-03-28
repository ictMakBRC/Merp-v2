<?php

use App\Http\Livewire\Grants\Dashboard\ProjectsDashboardComponent;
use App\Http\Livewire\Grants\GrantProfileComponent;
use App\Http\Livewire\Grants\GrantsComponent;
use App\Http\Livewire\Grants\Projects\ProjectComponent;
use App\Http\Livewire\Grants\Projects\ProjectContractsListComponent;
use App\Http\Livewire\Grants\Projects\ProjectProfileComponent;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'grants'], function () {

    Route::get('manage', GrantsComponent::class)->name('manage-grants');
    Route::get('{id}/profile', GrantProfileComponent::class)->name('grant-profile');

    Route::group(['prefix' => 'projects'], function () {
        Route::get('manage', ProjectComponent::class)->name('manage-projects');
        Route::get('{id}/profile', ProjectProfileComponent::class)->name('project-profile');

        Route::get('contracts', ProjectContractsListComponent::class)->name('project-contracts');
    });

    Route::get('dashboard', ProjectsDashboardComponent::class)->name('projects-dashboard');
});
