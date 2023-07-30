<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeesListComponent extends Component
{

    
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $employeeIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;


    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        // $this->reset();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->employeeIds) > 0) {
            // return (new EmployeesExport($this->employeeIds))->download('Employees_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Employees selected for export!',
            ]);
        }
    }

    public function filterEmployees()
    {
        $employees = Employee::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->employeeIds = $employees->pluck('id')->toArray();

        return $employees;
    }

    public function render()
    {
        $employees = $this->filterEmployees()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.human-resource.employee-data.employees-list-component',compact('employees'));
    }
}
