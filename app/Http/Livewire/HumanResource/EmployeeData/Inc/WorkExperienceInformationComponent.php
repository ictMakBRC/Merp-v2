<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\HumanResource\EmployeeData\WorkingExperienceData;
use App\Services\HumanResource\EmployeeData\WorkingExperienceInformationService;

class WorkExperienceInformationComponent extends Component
{
    public $employee_id;
    public $start_date;
    public $end_date;
    public $company;
    public $position_held;
    public $monthly_salary;
    public $currency;
    public $employment_type;
    public $key_responsibilities;

    public $loadingInfo='';
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
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
                    'currency'=> $this->currency,
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

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.work-experience-information-component');
    }
}
