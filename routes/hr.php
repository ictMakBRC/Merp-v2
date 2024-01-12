<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\HumanResource\Grievances\HrGrievancesComponent;
use App\Http\Livewire\HumanResource\Grievances\HrGrievanceTypesComponent;
use App\Http\Livewire\HumanResource\Grievances\HrUserGrievancesComponent;
use App\Http\Livewire\HumanResource\Requests\Leave\HrLeaveRequestsComponent;
use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;
use App\Http\Livewire\HumanResource\Performance\Appraisal\HrEmployeeAppraisalsComponent;
use App\Http\Livewire\HumanResource\Performance\Resignation\HrEmployeeResignationsComponent;
use App\Http\Livewire\HumanResource\Performance\Resignation\HrEmployeeResignationViewComponent;
use App\Http\Livewire\HumanResource\Performance\Termination\HrTerminationsComponent;
use App\Http\Livewire\HumanResource\Performance\Termination\HrTerminationViewComponent;
use App\Http\Livewire\HumanResource\Performance\Warnings\HrViewWarningComponent;
use App\Http\Livewire\HumanResource\Performance\Warnings\HrWarningsComponent;

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

    Route::group(['prefix' => 'warnings'], function () {
        Route::get('list/{type}', HrWarningsComponent::class)->name('hr_warnings');
        Route::get('view/{warning_id}', HrViewWarningComponent::class)->name('hr_warning_view');
    });
    Route::group(['prefix' => 'terminations'], function () {
        Route::get('list/{type}', HrTerminationsComponent::class)->name('hr_terminations');
        Route::get('view/{view_id}', HrTerminationViewComponent::class)->name('hr_termination_view');
    });
    Route::group(['prefix' => 'resignations'], function () {
        Route::get('list/{type}', HrEmployeeResignationsComponent::class)->name('hr_resignations');
        Route::get('view/{view_id}', HrEmployeeResignationViewComponent::class)->name('hr_resignations_view');
    });

    Route::group(['prefix' => 'appraisals'], function () {
        Route::get('list/{type}', HrEmployeeAppraisalsComponent::class)->name('hr_appraisals');
        Route::get('view/{view_id}', HrEmployeeResignationViewComponent::class)->name('hr_appraisals_view');
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
