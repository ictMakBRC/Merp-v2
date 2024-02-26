<?php

namespace App\Http\Livewire\HumanResource\Dashboard;

use Carbon\Carbon;
use Livewire\Component;

use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Grievance;

use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Performance\Appraisal;
use App\Models\HumanResource\Performance\Resignation;
use App\Models\HumanResource\Performance\ExitInterview;
use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class HumanResourceMainDashboardComponent extends Component
{
    public function averageTatForContractRenewal(){

        return OfficialContract::get()
        ->groupby('employee_id')
        ->filter(function ($employee) {
            return count($employee) > 1;

        })->map(function ($employee) {
            // Sort the contracts by start_date in descending order
            $sortedContracts = collect($employee)->sortByDesc('start_date');
        
            // Take the top two contracts
            $latestTwoContracts = $sortedContracts->take(2);
        
            // Convert start_date and end_date to Carbon instances
            $startDate = Carbon::parse($latestTwoContracts->first()->start_date);
            $endDate = Carbon::parse($latestTwoContracts->last()->end_date);
        
            // Calculate the number of days between the current contract's start date and the previous contract's end date
            $daysDifference = $startDate->diffInDays($endDate);
        
            // Return the employee_id, the latest two contracts, and the number of days difference
            return [
                'employee_id' => $employee[0]->employee_id,
                'latest_contracts' => $latestTwoContracts->values()->all(),
                'days_difference' => $daysDifference,
            ];
        })->pluck('days_difference')->avg();
    }

    public function joinedLeftPerYear(){
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Get the total number of employees that joined and left in each year
        $employeeData = Employee::selectRaw('YEAR(join_date) as year, COUNT(*) as join_count')
            ->groupBy('year')
            ->get();

        $leftEmployeeData = Employee::selectRaw('YEAR(left_at) as year, COUNT(*) as left_count')
            ->whereNotNull('left_at')
            ->groupBy('year')
            ->get();

            return $employeeData->map(function ($join) use ($leftEmployeeData) {
                $matchingLeave = $leftEmployeeData->firstWhere('year', $join['year']);
            
                return [
                    "year" => $join["year"],
                    "join_count" => $join["join_count"],
                    "left_count" => $matchingLeave ? $matchingLeave["left_count"] : 0,
                ];
            })->concat($leftEmployeeData->whereNotIn('year', $employeeData->pluck('year'))->map(function ($leave) {
                return [
                    "year" => $leave["year"],
                    "join_count" => 0,
                    "left_count" => $leave["left_count"],
                ];
            }));
        // Now $finalData contains the final output with the year, join_count, and left_count
        // You can use this data to plot the bar chart using Apex Charts or any other charting library

    }


    public function averageContractsSalary(){

        return OfficialContract::get()
        ->groupby('employee_id')
        ->map(function ($contracts) {
            // Sort the contracts by start_date in descending order
            $latestContract = collect($contracts)->sortByDesc('start_date')->first();
  
            return [
                'employee_id' => $latestContract->employee_id,
                'gross_salary' => $latestContract->gross_salary,
            ];
        })->pluck('gross_salary')->avg();
    }

    public function salaryDistributionPerDepartment(){

        return OfficialContract::with('employee.department')->get()->groupBy('employee_id')->map(function ($contracts) {
            // Sort the contracts by start_date in descending order
            $latestContract = collect($contracts)->sortByDesc('start_date')->first();
  
            return [
                'employee_id' => $latestContract->employee_id,
                'department' => $latestContract->employee?->department?->name??'N/A',
                'gross_salary' => $latestContract->gross_salary,
            ];
        })->values()->groupBy('department')->map(function ($department,$key) {
  
            return [
                'department' => $key,
                'total_salary' => $department->sum('gross_salary'),
                'avg_salary' => $department->avg('gross_salary'),
                'employees_count' => $department->count(),
            ];
        })->values();
    }

    public function getData(){

        $data['employees'] = Employee::where('is_active', true)->get();
        $data['employeeCount'] = $data['employees']->count();
        $data['departments'] = Department::where('is_active' ,true)->withCount('employees')->get();
        $data['departmentCount'] = $data['departments']->count();

        $data['projects'] = Project::where('end_date','>=',today())->withCount(['employees as running_contract_count' => function ($query) {
            $query->where('employee_project.status', 'Running')
                ->where('employee_project.end_date', '>', now());
        }])->get();

        $data['runningProjectsCount'] = $data['projects']->count();
        $data['employeesForRunningProjects']=$data['projects']->sum('running_contract_count');
        
        $data['genderDistribution'] = [
            'maleCount'=>$data['employees']->where('gender', 'Male')->count(),
            'femaleCount'=>$data['employees']->where('gender', 'Female')->count(),
        ];

        $data['averageTatForContractRenewal'] = $this->averageTatForContractRenewal();
        $data['joinedOrLeftPerYear'] = $this->joinedLeftPerYear();
        $data['averageContractsSalary'] = $this->averageContractsSalary();
        $data['salaryDistributionPerDepartment'] = $this->salaryDistributionPerDepartment();
        $data['wageBill'] = $this->salaryDistributionPerDepartment()->sum('total_salary');

       



        // $data['leaveCount'] = LeaveRequest::where(['status' => 'Approved', 'confirmation' => 'Confirmed', 'accepted_by' => null])->count();
        // $data['grievanceCount'] = Grievance::where('status', 'Pending')->count();
        // $data['resignationCount'] = Resignation::where('status', 'Pending')->count();
        // $data['exitInterviewCount'] = ExitInterview::whereBetween('created_at', [$prev_date, $today])->count();
        // $data['appraisalCount'] = Appraisal::whereBetween('created_at', [$prev_date, $today])->count();

        return $data;
    }

    public function render()
    {
        return view('livewire.human-resource.dashboard.human-resource-main-dashboard-component',$this->getData())->layout('layouts.app');
    }
}
