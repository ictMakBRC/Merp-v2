<?php

namespace App\Http\Livewire\Grants\Dashboard;

use App\Models\Grants\Grant;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;

class ProjectsDashboardComponent extends Component
{

    public function grantsAndProjectsPerYear(){

        $distinctYearsProjects = DB::table('projects')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

        // Eloquent query to get distinct years from grants
        $distinctYearsGrants = DB::table('grants')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

        // Combine distinct years from both projects and grants
        $distinctYears = array_unique(array_merge($distinctYearsProjects, $distinctYearsGrants));

        // Limit the distinct years to the last ten years
        $lastTenYears = array_slice($distinctYears, 0, 10);

        // Eloquent query to get the number of projects per year
        $projectsPerYear = DB::table('projects')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as projects_count'))
            ->whereIn(DB::raw('YEAR(created_at)'), $lastTenYears)
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->get()
            ->keyBy('year');

        // Eloquent query to get the number of grants per year
        $grantsPerYear = DB::table('grants')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as grants_count'))
            ->whereIn(DB::raw('YEAR(created_at)'), $lastTenYears)
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->get()
            ->keyBy('year');

        // Prepare data for Apex line chart
        $chartData = [];

        foreach ($lastTenYears as $year) {
            $chartData[$year] = [
                'grants_count' => isset($grantsPerYear[$year]) ? max(0, $grantsPerYear[$year]->grants_count) : 0,
                'projects_count' => isset($projectsPerYear[$year]) ? max(0, $projectsPerYear[$year]->projects_count) : 0,
            ];
        }

        return $chartData;
    }

    public function getData(){

        $projects=Project::get();
        $grants=Grant::get();
        $data['totalGrants']= $grants->count();
        $data['totalProjects']= $projects->count();

        $data['totalFundsForRunningProjects'] = $projects
        ->where('end_date', '>=', today())
        ->sum(function ($project) {
            return exchangeToDefaultCurrency($project->currency_id, $project->funding_amount);
        });

        $projectStatus['totalEminentProjects']= $projects->where('start_date','>',today())->count();
        $projectStatus['totalRunningProjects']= $projects->where('end_date','>=',today())->count();
        $projectStatus['totalCompletedProjects']= $projects->where('end_date','<',today())->count();
        $data['projectStatus']=array_values($projectStatus);

        $data['grantsAndProjectsPerYear'] = $this->grantsAndProjectsPerYear();

        $data['projects'] = Project::with('principalInvestigator')->where('end_date','>=',today())->addSelect([
            'projects.*',
            DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire')
        ])->withCount(['employees as running_contract_count' => function ($query) {
            $query->where('employee_project.status', 'Running')
                  ->where('employee_project.end_date', '>', now());
        }])->get();

        $data['employeesForRunningProjects']=$data['projects']->sum('running_contract_count');

        return $data;
    }

    public function render()
    {
      
        return view('livewire.grants.dashboard.projects-dashboard-component',$this->getData());
    }
}
