<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use App\Data\Grants\ProjectData;
use App\Models\Grants\Project\EmployeeProject;
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

    public $project;
    public $contractId;
    public $employees;

    public $special_role;
    public $editMode=false;

    protected $listeners = [
        'projectCreated' => 'loadProject',
        'loadProject' => 'loadProject',
    ];

    public function mount(){
        $this->employees=collect([]);
    }

    public function loadProject($details)
    {
        $this->project_id = $details['projectId'];
        $project = Project::with('employees')->findOrFail($this->project_id);
        $this->project = $project;
        $this->employees = $project->employees;
        $this->currencyCode = getCurrencyCode($project->currency_id);
    }

    public function updatedProjectId()
    {
        if($this->project_id){
            $project = Project::with('employees')->findOrFail($this->project_id);
            $this->project = $project;
            $this->employees = $project->employees;
            $this->currencyCode = getCurrencyCode($project->currency_id);
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

            if ($this->special_role != '') {
                $project=Project::findOrFail($this->project_id);
                if ($this->special_role == 'pi') {
                    $project->update(['pi' => $this->employee_id]);

                } else {
                    $project->update(['coordinator_id' => $this->employee_id]);
                }
                $this->reset('special_role');
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Employee attached to Project/Study successfully']);
            $this->reset($projectDTO->resetProjectEmployeeInputs());

        });
    }

    public function loadContract($contractId){
        $contract = EmployeeProject::findOrFail($contractId);
        $this->contractId=$contractId;
        $this->employees = $this->project->employees;
        $this->employee_id = $contract->employee_id;
        $this->designation_id = $contract->designation_id;
        $this->contract_summary = $contract->contract_summary;
        $this->contract_start_date = $contract->start_date;
        $this->contract_end_date = $contract->end_date;
        $this->fte = $contract->fte;
        $this->gross_salary = $contract->gross_salary;
        $this->contract_file_path = $contract->contract_file_path;
        $this->status = $contract->status;

        $this->editMode=true;
    }

    public function updateProjectContract()
    {
        $projectDTO = new ProjectData();
        $this->validate($projectDTO->projectEmployeeRules());

        DB::transaction(function (){

            if ($this->contract_file != null) {
                $this->validate([
                    'contract_file' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $contractFileName = date('YmdHis').'.'.$this->contract_file->extension();

                if (file_exists(storage_path().$this->contract_file_path)) {
                    @unlink(storage_path().$this->contract_file_path);
                }

                $this->contract_file_path = $this->contract_file->storeAs('employees/project-contracts', $contractFileName);
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
            $projectEmployee = $projectService->updateProjectContract($this->contractId,$projectDTO);

            if ($this->special_role != '') {
                $project=Project::findOrFail($this->project_id);
                if ($this->special_role == 'pi') {
                    $project->update(['pi' => $this->employee_id]);

                } else {
                    $project->update(['coordinator_id' => $this->employee_id]);
                }
                $this->reset('special_role');
            }

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Employee Project Contract updated successfully']);
            $this->reset($projectDTO->resetProjectEmployeeInputs());
            $this->contractId=null;
            $this->editMode=false;

        });

        $this->employees = $this->project->employees;
    }
 
    public function render()
    {
        $data['projects'] = Project::where('end_date','>=',today())->get();
        $data['designations'] = Designation::where('is_active',true)->get();
        $data['employees_list'] = Employee::where('is_active',true)->get();

        return view('livewire.grants.projects.inc.project-employees-component',$data);
    }
}
