<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class EducationInformationComponent extends Component
{
    public $employee_id;
    public $level;
    public $school;
    public $start_date;
    public $end_date;
    public $award;
    public $award_document;
    
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
        return view('livewire.human-resource.employee-data.inc.education-information-component');
    }
}
