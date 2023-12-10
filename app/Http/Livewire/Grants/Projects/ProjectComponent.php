<?php

namespace App\Http\Livewire\Grants\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;

class ProjectComponent extends Component
{
    use WithPagination;

    //Filters
    public $project_id;
    public $projectIds;
    public $user_category;

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
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->projectIds = $projects->pluck('id')->toArray();

        return $projects;
    }

    public function render()
    {
        $data['projects'] = $this->filterProjects()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.grants.projects.project-component', $data);
    }
}
