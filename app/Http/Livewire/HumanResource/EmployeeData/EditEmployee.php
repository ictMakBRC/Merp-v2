<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use App\Models\HumanResource\EmployeeData\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EditEmployee extends Component
{
    use WithPagination;

    public $employee;

    protected $paginationTheme = 'bootstrap';

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.human-resource.employee-data.edit', ['employee' => $this->employee]);
    }
}
