<?php

use App\Http\Livewire\Global\DepartmentsComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HumanResource\Settings\HolidaysComponent;
use App\Http\Livewire\HumanResource\Settings\StationsComponent;
use App\Http\Livewire\HumanResource\Settings\DesignationsComponent;
use App\Http\Livewire\HumanResource\Settings\LeavesComponent;
use App\Http\Livewire\HumanResource\Settings\OfficesComponent;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('stations', StationsComponent::class)->name('human-resource-stations');
    Route::get('designations', DesignationsComponent::class)->name('human-resource-designations');
    Route::get('holidays', HolidaysComponent::class)->name('human-resource-holidays');
    Route::get('offices', OfficesComponent::class)->name('human-resource-offices');
    Route::get('leaves', LeavesComponent::class)->name('human-resource-leaves');
    Route::get('departments', DepartmentsComponent::class)->name('human-resource-departments');
});
