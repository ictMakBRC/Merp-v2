<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\WorkingExperienceData;
use App\Models\HumanResource\EmployeeData\WorkExperience;
use App\Services\HumanResource\EmployeeData\WorkingExperienceInformationService;

class WorkExperienceInformationComponent extends Component
{
    public $employee_id;
    public $start_date;
    public $end_date;
    public $company;
    public $position_held;
    public $monthly_salary;
    public $currency_id;
    public $employment_type;
    public $key_responsibilities;

    public $loadingInfo='';
    
    public $toggleForm=false;
    public $workingInfo;
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
        $this->toggleForm=false;
        $workingExperienceInformationDTO = new WorkingExperienceData();
        $this->reset($workingExperienceInformationDTO->resetInputs());
    }

    public function storeWorkingExperienceInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $workingExperienceInformationDTO = new WorkingExperienceData();
        $this->validate($workingExperienceInformationDTO->rules());

        DB::transaction(function (){
 
            $workingExperienceInformationDTO = WorkingExperienceData::from([
                    'employee_id'=>$this->employee_id,
                    'start_date'=>$this->start_date,
                    'end_date'=> $this->end_date,
                    'company'=> $this->company,
                    'position_held'=> $this->position_held,
                    'monthly_salary'=> $this->monthly_salary,
                    'currency_id'=> $this->currency_id,
                    'employment_type'=> $this->employment_type,
                    'key_responsibilities'=> $this->key_responsibilities,
                ]
            );
  
            $workingExperienceInformationService = new WorkingExperienceInformationService();

            $workingExperienceInformation = $workingExperienceInformationService->createWorkingExperienceInformation($workingExperienceInformationDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Working Experience information details created successfully']);

            $this->reset($workingExperienceInformationDTO->resetInputs());

        });
    }

    public function editData(WorkExperience $workExperience)
    {
        $this->workingInfo = $workExperience;

        $this->start_date = $workExperience->start_date;
        $this->end_date =  $workExperience->end_date;
        $this->company =  $workExperience->company;
        $this->position_held =  $workExperience->position_held;
        $this->monthly_salary =  $workExperience->monthly_salary;
        $this->currency_id =  $workExperience->currency_id;
        $this->employment_type =  $workExperience->employment_type;
        $this->key_responsibilities =  $workExperience->key_responsibilities;
 
        $this->toggleForm = true;
    }

    public function updateWorkingExperienceInformation()
    {
        if ($this->employee_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No employee has been selected for this operation!',
            ]);
            return;
        }

        $workInformationDTO = new WorkingExperienceData();
        $this->validate($workInformationDTO->rules());

        DB::transaction(function (){
            $workingExperienceDTO = WorkingExperienceData::from([
                'employee_id'=>$this->employee_id,
                'start_date'=>$this->start_date,
                'end_date'=> $this->end_date,
                'company'=> $this->company,
                'position_held'=> $this->position_held,
                'monthly_salary'=> $this->monthly_salary,
                'currency_id'=> $this->currency_id,
                'employment_type'=> $this->employment_type,
                'key_responsibilities'=> $this->key_responsibilities,
                ]
            );
  
            $workInformationService = new WorkingExperienceInformationService();

            $workInformation = $workInformationService->updateWorkingExperienceInformation($this->workingInfo,$workingExperienceDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Work Experience information details updated successfully']);

            $this->reset($workingExperienceDTO ->resetInputs());
            $this->toggleForm=false;

        });
    }
    public function render()
    {
        $data['workExperienceInformation'] = WorkExperience::where('employee_id',$this->employee_id)->get()??collect([]);
       
        return view('livewire.human-resource.employee-data.inc.work-experience-information-component',$data);
    }
}
