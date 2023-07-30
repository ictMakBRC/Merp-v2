<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HumanResource\Settings\CompanyProfileComponent;
use App\Http\Livewire\HumanResource\Settings\LeavesComponent;
use App\Http\Livewire\HumanResource\Settings\OfficesComponent;
use App\Http\Livewire\HumanResource\Settings\HolidaysComponent;
use App\Http\Livewire\HumanResource\Settings\StationsComponent;
use App\Http\Livewire\HumanResource\Settings\DepartmentsComponent;
use App\Http\Livewire\HumanResource\Settings\DesignationsComponent;
use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;
use App\Http\Livewire\HumanResource\EmployeeData\EmployeeDataComponent;
use App\Http\Livewire\HumanResource\EmployeeData\EmployeesListComponent;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('dashboard', HumanResourceMainDashboardComponent::class)->name('human-resource-dashboard');

    Route::group(['prefix' => 'settings'], function () {
        
        Route::get('company-profile', CompanyProfileComponent::class)->name('company-profile');
        Route::get('stations', StationsComponent::class)->name('human-resource-stations');
        Route::get('departments', DepartmentsComponent::class)->name('human-resource-departments');
        Route::get('designations', DesignationsComponent::class)->name('human-resource-designations');
        Route::get('holidays', HolidaysComponent::class)->name('human-resource-holidays');
        Route::get('offices', OfficesComponent::class)->name('human-resource-offices');
        Route::get('leaves', LeavesComponent::class)->name('human-resource-leaves');
        
    });

    Route::get('capture-new-info', EmployeeDataComponent::class)->name('human-resource-capture-new-info');
    Route::get('employees', EmployeesListComponent::class)->name('human-resource-employees-list');

    
});
