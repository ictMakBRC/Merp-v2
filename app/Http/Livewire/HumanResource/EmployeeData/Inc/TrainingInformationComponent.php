<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\Inc;

use Livewire\Component;

class TrainingInformationComponent extends Component
{
    public $employee_id;
    public $start_date;
    public $end_date;
    public $organised_by;
    public $training_title;
    public $description;
    public $certificate;
    public function render()
    {
        return view('livewire.human-resource.employee-data.inc.training-information-component');
    }
}
