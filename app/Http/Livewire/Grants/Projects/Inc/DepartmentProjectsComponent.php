<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;

class DepartmentProjectsComponent extends Component
{
    use WithFileUploads;
    
    public $project_id;
    public $project_departments = [];

    public $selectedDepartments;

    protected $listeners = [
        'projectCreated' => 'setProjectId',
        'loadProject' => 'setProjectId',
    ];

    public function setProjectId($details)
    {
        $this->project_id = $details['projectId'];
    }

    public function mount()
    {
        $this->selectedDepartments = collect([]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedProjectDepartments()
    {
        $this->selectedDepartments = Department::whereIn('id', $this->project_departments)->get();
    }

    public function attachDepartments()
    {
        if ($this->project_id) {
            $this->validate([
                'project_id' => 'required',
            ]);

            $project = Project::findOrFail($this->project_id);
            $project->departments()->sync($this->project_departments);
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Project Departments/Labs attached successfully,']);

        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Not found!',
                'text' => 'No Project Selected, Please select or create project',
            ]);
        }
    }

    public function detachDepartment($departmentId)
    {
        $index = array_search($departmentId, $this->project_departments);

        if ($index !== false) {
            unset($this->project_departments[$index]);
            $this->project_departments = array_values($this->project_departments);
            $this->selectedDepartments = Department::whereIn('id', $this->project_departments)->get();

        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Not found!',
                'text' => 'Department not found',
            ]);
        }
    }

    public function resetInputs()
    {
        $this->reset(['project_id']);
        $this->project_departments = [];
        $this->selectedDepartments = collect([]);
    }
 
    public function render()
    {
        $data['projects'] = Project::where('end_date','>',today())->get();
        $data['departments'] = Department::where('type','Laboratory')->get();
        return view('livewire.grants.projects.inc.department-projects-component', $data);
    }
}
