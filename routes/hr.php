<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\HumanResource\Grievances\HrGrievancesComponent;
use App\Http\Livewire\HumanResource\Grievances\HrGrievanceTypesComponent;
use App\Http\Livewire\HumanResource\Grievances\HrUserGrievancesComponent;
use App\Http\Livewire\HumanResource\Requests\Leave\HrLeaveRequestsComponent;
use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('/', HumanResourceMainDashboardComponent::class)->name('human-resource-dashboard');


    Route::group(['prefix' => 'leaves'], function () {
        Route::get('requests/{{type}}', HrLeaveRequestsComponent::class)->name('hr-leave_requests');
        
    });

    Route::group(['prefix' => 'grievances'], function () {
        Route::get('types', HrGrievanceTypesComponent::class)->name('hr_grievances-types');
        Route::get('list/{type}', HrGrievancesComponent::class)->name('hr_grievances-list');
        Route::get('mine', HrUserGrievancesComponent::class)->name('hr_grievances-user');
    });

    //performances
    Route::group(['prefix' => 'performance'], function () {
        //appraisals
        Route::group(['prefix' => 'appraisals'], function () {
        
        });
        //warnings
        Route::group(['prefix' => 'warnings'], function () {
        
        });

        //Terminations
        Route::group(['prefix' => 'terminations'], function () {
        
        });

        //Resignations
        Route::group(['prefix' => 'resignations'], function () {
        
        });

        //ExitInterviews
        Route::group(['prefix' => 'exit-interviews'], function () {
        
        });
    });




});
