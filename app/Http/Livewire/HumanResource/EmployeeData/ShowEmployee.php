<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\EmployeeData\Employee;

class ShowEmployee extends Component
{
    public $employee;

    protected $paginationTheme = 'bootstrap';

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        // dd($this->employee->designation);
        return view('livewire.human-resource.employee-data.show');
    }
}
