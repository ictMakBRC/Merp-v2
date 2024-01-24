<?php

namespace App\Http\Livewire\Grants\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\EmployeeData\Employee;

class ProjectComponent extends Component
{
    use WithPagination;

    //Filters
    public $project_id;
    public $projectIds;
    public $project_category;
    public $project_type;
    public $pi;
    public $progress_status;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    protected $listeners = [
        'projectCreated',
    ];

    public function projectCreated($details)
    {
        $this->project_id = $details['projectId'];
    }

    public function updatedCreateNew()
    {
        // $this->reset();
        $this->toggleForm = !$this->toggleForm;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadProject(Project $project):void
    {
        $loadingInfo = 'For '.$project->project_code;
            $this->emit('loadProject', [
                'projectId' => $project->id,
                'info'=>$loadingInfo,
            ]);
           
        $this->createNew = true;
        $this->toggleForm = true;
    }

    
    public function filterProjects()
    {
        $projects = Project::search($this->search)->with('principalInvestigator')
        ->when($this->pi != 0, function ($query){
            $query->where('pi',$this->pi);
        })
        ->when($this->project_category != '', function ($query){
            $query->where('project_category',$this->project_category);
        })
        ->when($this->project_type != '', function ($query){
            $query->where('project_type',$this->project_type);
        })
        ->when($this->progress_status != '', function ($query){
            $query->where('progress_status',$this->progress_status);
        })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })
            ->addSelect([
                'projects.*',
                DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire')
            ]);

        $this->projectIds = $projects->pluck('id')->toArray();

        return $projects;
    }

    public function render()
    {
        $data['projects'] = $this->filterProjects()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        $data['employees'] = Employee::where('is_active', true)->get();
        return view('livewire.grants.projects.project-component', $data);
    }
}
