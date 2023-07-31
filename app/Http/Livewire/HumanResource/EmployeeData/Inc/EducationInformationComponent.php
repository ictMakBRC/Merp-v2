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
    
    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.education-information-component');
    }
}
