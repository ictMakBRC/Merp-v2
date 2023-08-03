<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

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
    public $job_description;

    public $loadingInfo='';
    
    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.work-experience-information-component');
    }
}
