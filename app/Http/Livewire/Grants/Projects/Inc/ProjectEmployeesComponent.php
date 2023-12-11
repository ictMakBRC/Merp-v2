<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use App\Data\Grants\ProjectData;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Services\Grants\ProjectService;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;
use Livewire\WithFileUploads;

class ProjectEmployeesComponent extends Component
{
    use WithFileUploads;
    public $project_id;
    public $employee_id;
    public $designation_id;
    public $contract_summary;
    public $contract_start_date;
    public $contract_end_date;
    public $fte;
    public $gross_salary;
    public $contract_file;
    public $contract_file_path;
    public $status;
    public $currencyCode;

    protected $listeners = [
        'projectCreated' => 'setProjectId',
        'loadProject' => 'setProjectId',
    ];

    
    public function setProjectId($details)
    {
        $this->project_id = $details['projectId'];
        $this->currencyCode = getCurrencyCode(Project::findOrFail($this->project_id)->currency_id);
    }

    public function updatedProjectId()
    {
        if($this->project_id){
            $this->currencyCode = getCurrencyCode(Project::findOrFail($this->project_id)->currency_id);
        }else{
            $this->currencyCode='';
        }
    }

    public function attachEmployee()
    {
        $projectDTO = new ProjectData();
        $this->validate($projectDTO->projectEmployeeRules());

        DB::transaction(function (){

            if ($this->contract_file != null) {
                $this->validate([
                    'contract_file' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $contractFileName = date('YmdHis').'.'.$this->contract_file->extension();
                $this->contract_file_path = $this->contract_file->storeAs('employees/project-contracts', $contractFileName);
            } else {
                $this->contract_file_path = null;
            }

            $projectDTO = ProjectData::from([
                'project_id' => $this->project_id,
                'employee_id' => $this->employee_id,
                'designation_id' => $this->designation_id,
                'contract_summary' => $this->contract_summary,
                'contract_start_date' => $this->contract_start_date,
                'contract_end_date' => $this->contract_end_date,
                'fte' => $this->fte,
                'gross_salary' => $this->gross_salary,
                'contract_file_path' => $this->contract_file_path,
                'status' => $this->status,
                ]
            );

            $projectService = new ProjectService();
            $projectEmployee = $projectService->attachEmployee($projectDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Employee attached to Project/Study successfully']);
            $this->reset($projectDTO->resetProjectEmployeeInputs());

        });
    }

    public function render()
    {
        $data['projects'] = Project::where('end_date','>',today())->get();
        $data['designations'] = Designation::where('is_active',true)->get();
        $data['employees'] = Employee::where('is_active',true)->get();
        return view('livewire.grants.projects.inc.project-employees-component',$data);
    }
}
