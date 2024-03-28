<?php

namespace App\Http\Livewire\Grants\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Grants\Project\EmployeeProject;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Exports\Projects\ProjectEmployeeContractExport;

class ProjectContractsListComponent extends Component
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
    public $project_id;
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
            return (new ProjectEmployeeContractExport($this->contractIds))->download('ProjectContracts_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
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
        $contracts = EmployeeProject::with('employee','project','project.currency','designation')->when($this->employee_id != 0, function ($query) {
            $query->where('employee_id', $this->employee_id);
        }, function ($query) {
            return $query;
        })->when($this->project_id != 0, function ($query){
            $query->where('id',$this->project_id);
        })
        ->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        });

        $this->contractIds = $contracts->pluck('id')->toArray();

        return $contracts;
    }

    public function downloadContract($filePath){
        try {
            return downloadFile($filePath);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        } 
    }

    public function render()
    {
        // dd($this->filterContracts()->get());
        $data['contracts'] = $this->filterContracts()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
            
        $data['employees'] = Employee::where('is_active',true)->orderBy('first_name','asc')->get();
        $data['projects'] = Project::whereHas('employees')->get();

        return view('livewire.grants.projects.project-contracts-list-component',$data);
    }
}
