<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeeDetailsComponent extends Component
{
    public $emp_id;
    public function mount($id){
        $this->emp_id=$id;
    }
    public function render()
    {
        $data['employee'] = Employee::findOrFail($this->emp_id);
        return view('livewire.human-resource.employee-data.employee-details-component',$data);
    }
}
