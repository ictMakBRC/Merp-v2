<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeeDataComponent extends Component
{
    public $employee_id;
    public $loadingInfo='';

    protected $listeners = [
        'switchEmployee' => 'setEmployeeId',
    ];

    public function setEmployeeId($details)
    {
        $this->employee_id = $details['employeeId'];
        $this->loadingInfo = $details['info'];
    }

    public function updatedEmployeeId()
    {
        if ($this->employee_id) {
            $employee=Employee::findOrFail($this->employee_id);
            $this->loadingInfo = 'For '.$employee->fullName.' ('.$employee->employee_number.')';
            $this->emit('switchEmployee', [
                'employeeId' => $this->employee_id,
                'info'=>$this->loadingInfo,
            ]);
        }else{
            $this->employee_id=null;
            $this->loadingInfo='';
            $this->emit('switchEmployee', [
                'employeeId' => null,
                'info'=>'',
            ]);
        }
    }


    public function render()
    {
        $employees = Employee::where('is_active',true)->orderBy('first_name', 'asc')->get();
        return view('livewire.human-resource.employee-data.employee-data-component',compact('employees'));
    }
}
