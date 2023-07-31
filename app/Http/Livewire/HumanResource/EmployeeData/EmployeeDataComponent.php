<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;

class EmployeeDataComponent extends Component
{
    public $employee_id;
    public function render()
    {
        return view('livewire.human-resource.employee-data.employee-data-component');
    }
}
