<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\OfficialContracts;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class OfficialContractsListComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $exportIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $is_active =1;
    public $department_id;
    public $employee_id;
    public $days_to_expire=0;

    protected $paginationTheme = 'bootstrap';

    public $contractIds;

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
        if (count($this->contractIds) > 0) {
            return (new EmployeesExport($this->employeeIds))->download('Employees_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Contracts selected for export!',
            ]);
        }
    }

    public function filterContracts()
    {
        $contracts = OfficialContract::search($this->search)->with('employee','employee.department','employee.designation','currency')
        ->when($this->department_id != 0, function ($query){
            $query->whereHas('employee',function($query){
                $query->where('department_id',$this->department_id);
            });
        })
        ->when($this->employee_id != 0, function ($query){
            $query->where('employee_id',$this->employee_id);
        })
        ->when($this->days_to_expire > 0, function ($query) {
            $query->whereRaw('DATEDIFF(end_date, CURRENT_DATE()) = ?', [$this->days_to_expire]);
        })
        ->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        })
        ->addSelect([
            'official_contracts.*', // Include other fields from the contracts table
            DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire')
        ])
        ;

        $this->contractIds = $contracts->pluck('id')->toArray();

        return $contracts;
    }

    public function render()
    {
        $data['contracts'] = $this->filterContracts()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
            
        $data['employees'] = Employee::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();

        return view('livewire.human-resource.employee-data.official-contracts.official-contracts-list-component',$data);
    }
}
