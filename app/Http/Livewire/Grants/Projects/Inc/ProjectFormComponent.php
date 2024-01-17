<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use App\Data\Grants\ProjectData;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Services\Grants\ProjectService;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;

class ProjectFormComponent extends Component
{
    public $project_code;
    public $name;
    public $project_category;
    public $project_type;
    // public $associated_institution;
    // public $grant_id;
    public $funding_source;
    public $funding_amount;
    public $currency_id;
    public $start_date;
    public $end_date;
    // public $pi;
    // public $co_pi;
    public $project_summary;
    public $progress_status;

    public $project;
    public $project_id;
    public $loadingInfo='';
    public $editMode =false;

    protected $listeners = [
        'loadProject',
    ];

    public function loadProject($details)
    {
        $this->project_id = $details['projectId'];
        $this->loadingInfo = $details['info'];

        $project=Project::findOrFail($this->project_id);
        $this->project = $project;
        $this->project_type = $project->project_type;
        $this->project_category = $project->project_category;
        // $this->associated_institution = $project->associated_institution;
        $this->project_code = $project->project_code;
        $this->name = $project->name;
        // $this->grant_id = $project->grant_id??null;
        $this->funding_source = $project->funding_source;
        $this->funding_amount = $project->funding_amount;
        $this->currency_id = $project->currency_id;
        // $this->pi = $project->pi??null;
        // $this->co_pi = $project->co_pi??null;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->project_summary = $project->project_summary;
        $this->progress_status = $project->progress_status;

        $this->editMode=true;
    }

    public function storeProject()
    {
       
        $projectDTO = new ProjectData();
       
        $this->validate($projectDTO->rules());
        // dd('YES');
        DB::transaction(function (){

            $projectDTO = ProjectData::from([
                'project_type' => $this->project_type,
                'project_category' => $this->project_category,
                // 'associated_institution' => $this->associated_institution,
                'project_code' => $this->project_code,
                'name' => $this->name,
                // 'grant_id' => $this->grant_id??null,
                'funding_source' => $this->funding_source,
                'funding_amount' => $this->funding_amount,
                'currency_id' => $this->currency_id,
                // 'pi' => $this->pi??null,
                // 'co_pi' => $this->co_pi??null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'project_summary' => $this->project_summary,
                'progress_status' => $this->progress_status,
                ]
            );

            $projectService = new ProjectService();
            $project = $projectService->createProject($projectDTO);

            $this->emit('projectCreated', [
                'projectId' => $project->id,
            ]);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Project/study details created successfully']);
            $this->reset($projectDTO->resetInputs());

        });
    }

    public function updateProject()
    {
        $projectDTO = new ProjectData();
        $this->validate($projectDTO->updateRules());

        DB::transaction(function (){

            $projectDTO = ProjectData::from([
                'project_type' => $this->project_type,
                'project_category' => $this->project_category,
                // 'associated_institution' => $this->associated_institution,
                'project_code' => $this->project_code,
                'name' => $this->name,
                // 'grant_id' => $this->grant_id??null,
                'funding_source' => $this->funding_source,
                'funding_amount' => $this->funding_amount,
                'currency_id' => $this->currency_id,
                // 'pi' => $this->pi??null,
                // 'co_pi' => $this->co_pi??null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'project_summary' => $this->project_summary,
                'progress_status' => $this->progress_status,
                ]
            );
  
            $projectService = new ProjectService();

            $project = $projectService->updateProject($this->project,$projectDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Project/study details created successfully']);

            $this->reset($projectDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['employees'] = Employee::where('is_active',true)->get();
        return view('livewire.grants.projects.inc.project-form-component',$data);
    }
}
