<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HumanResource\Settings\LeaveTypesComponent;
use App\Http\Livewire\HumanResource\Settings\OfficesComponent;
use App\Http\Livewire\HumanResource\Settings\HolidaysComponent;
use App\Http\Livewire\HumanResource\Settings\StationsComponent;
use App\Http\Livewire\HumanResource\Settings\DepartmentsComponent;
use App\Http\Livewire\HumanResource\Settings\DesignationsComponent;
use App\Http\Livewire\HumanResource\Settings\CompanyProfileComponent;
use App\Http\Livewire\HumanResource\EmployeeData\EmployeeDataComponent;
use App\Http\Livewire\HumanResource\EmployeeData\EmployeesListComponent;
use App\Http\Livewire\HumanResource\Grievances\Create as RegisterGrievance;
use App\Http\Livewire\HumanResource\Grievances\Index as Grievances;
use App\Http\Livewire\HumanResource\GrievanceTypes\Index as GrievanceTypes;
use App\Http\Livewire\HumanResource\Dashboard\HumanResourceMainDashboardComponent;
use App\Http\Livewire\HumanResource\Grievances\Edit as EditGrievance;
use App\Http\Livewire\HumanResource\Leave\DepartmentalRequests;
use App\Http\Livewire\HumanResource\Performance\Appraisals\Index as Appraisals;
use App\Http\Livewire\HumanResource\Performance\Appraisals\Create as RegisterAppraisal;
use App\Http\Livewire\HumanResource\Performance\Appraisals\Edit as EditAppraisal;
use App\Http\Livewire\HumanResource\Performance\Warnings\Index as Warnings;
use App\Http\Livewire\HumanResource\Performance\Warnings\Create as RegisterWarning;
use App\Http\Livewire\HumanResource\Performance\Warnings\Edit as EditWarning;
use App\Http\Livewire\HumanResource\Performance\Resignations\Index as Resignations;
use App\Http\Livewire\HumanResource\Performance\Resignations\Create as RegisterResignation;
use App\Http\Livewire\HumanResource\Performance\Resignations\Edit as EditResignation;
use App\Http\Livewire\HumanResource\Performance\Terminations\Index as Terminations;
use App\Http\Livewire\HumanResource\Performance\Terminations\Create as RegisterTermination;
use App\Http\Livewire\HumanResource\Performance\Terminations\Edit as EditTermination;
use App\Http\Livewire\HumanResource\Performance\ExitInterviews\Index as ExitInterviews;
use App\Http\Livewire\HumanResource\Performance\ExitInterviews\Create as RegisterExitInterview;
use App\Http\Livewire\HumanResource\Performance\ExitInterviews\Edit as EditExitInterview;
use App\Http\Livewire\HumanResource\Leave\NewRequest as NewLeaveRequest;
use App\Http\Livewire\HumanResource\Leave\EditRequest as EditLeaveRequest;
use App\Http\Livewire\HumanResource\Leave\LeaveDelegations;
use App\Http\Livewire\HumanResource\Leave\Requests as LeaveRequests;

Route::group(['prefix' => 'human-resource'], function () {
    Route::get('dashboard', HumanResourceMainDashboardComponent::class)->name('human-resource-dashboard');

    Route::group(['prefix' => 'settings'], function () {

        Route::get('company-profile', CompanyProfileComponent::class)->name('company-profile');
        Route::get('stations', StationsComponent::class)->name('human-resource-stations');
        Route::get('departments', DepartmentsComponent::class)->name('human-resource-departments');
        Route::get('designations', DesignationsComponent::class)->name('human-resource-designations');
        Route::get('holidays', HolidaysComponent::class)->name('human-resource-holidays');
        Route::get('offices', OfficesComponent::class)->name('human-resource-offices');
        Route::get('leaves-types', LeaveTypesComponent::class)->name('human-resource-leave-types');

    });

    Route::group(['prefix' => 'employees'], function () {
        Route::get('new-info', EmployeeDataComponent::class)->name('human-resource-capture-new-info');
        Route::get('list', EmployeesListComponent::class)->name('human-resource-employees-list');
    });
    Route::group(['prefix' => 'leave'], function () {
        Route::get('new-request/new', NewLeaveRequest::class)->name('leave.new-request');
        Route::get('requests/{leaveRequest}/update', EditLeaveRequest::class)->name('leaves.edit-request');
        Route::get('requests', LeaveRequests::class)->name('leave.requests');
        Route::get('requests/delegations', LeaveDelegations::class)->name('leave.requests.delegations');
        Route::get('requests/departmental', DepartmentalRequests::class)->name('leave.requests.departmental');
    });

    Route::group(['prefix' => 'grievances'], function () {
        Route::get('/', Grievances::class)->name('grievances');
        Route::get('create', RegisterGrievance::class)->name('grievances.create');
        Route::get('/{grievance}', EditGrievance::class)->name('grievances.update');
    });

    //performances
    Route::group(['prefix' => 'performance'], function () {
        //appraisals
        Route::group(['prefix' => 'appraisals'], function () {
            Route::get('/', Appraisals::class)->name('appraisals');
            Route::get('create', RegisterAppraisal::class)->name('appraisals.create');
            Route::get('/{appraisal}', EditAppraisal::class)->name('appraisals.update');
        });
        //warnings
        Route::group(['prefix' => 'warnings'], function () {
            Route::get('/', Warnings::class)->name('warnings');
            Route::get('create', RegisterWarning::class)->name('warnings.create');
            Route::get('/{warning}', EditWarning::class)->name('warnings.update');
        });

        //Terminations
        Route::group(['prefix' => 'terminations'], function () {
            Route::get('/', Terminations::class)->name('terminations');
            Route::get('create', RegisterTermination::class)->name('terminations.create');
            Route::get('/{termination}', EditTermination::class)->name('terminations.update');
        });

        //Resignations
        Route::group(['prefix' => 'resignations'], function () {
            Route::get('/', Resignations::class)->name('resignations');
            Route::get('create', RegisterResignation::class)->name('resignations.create');
            Route::get('/{resignation}', EditResignation::class)->name('resignations.update');
        });

        //ExitInterviews
        Route::group(['prefix' => 'exit-interviews'], function () {
            Route::get('/', ExitInterviews::class)->name('exit-interviews');
            Route::get('create', RegisterExitInterview::class)->name('exit-interviews.create');
            Route::get('/{exitInterview}', EditExitInterview::class)->name('exit-interviews.update');
        });
    });

    Route::group(['prefix' => 'grievance-types'], function () {
        Route::get('/', GrievanceTypes::class)->name('grievance-types');
    });


});
