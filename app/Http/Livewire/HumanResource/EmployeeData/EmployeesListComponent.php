<?php

namespace App\Http\Livewire\HumanResource\EmployeeData;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Settings\Designation;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeesListComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $employeeIds;

    public $perPage = 5;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;


    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $filter = false;

    public $entry_type;
    public $nin_number;
    public $title;
    public $surname;
    public $first_name;
    public $other_name;
    public $gender;
    public $nationality;
    public $from_dob;
    public $to_dob;
    public $birth_place;
    public $religious_affiliation;
  
    public $blood_type;
    public $civil_status;
    public $address;
    public $email;
    public $alt_email;
    public $contact;
    public $alt_contact;

    public $designation_id;
    public $station_id;
    public $department_id;
    public $project_id;
    
    public $work_type;
    public $from_join_date;
    public $to_join_date;
    public $tin_number;
    public $nssf_number;

    public $is_active;


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
            return (new EmployeesExport($this->employeeIds))->download('Employees_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
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
        ->when($this->entry_type != 0, function ($query){
            $query->where('entry_type',$this->entry_type);
        })
        ->when($this->department_id != 0, function ($query){
            $query->where('department_id',$this->department_id);
        })
        ->when($this->gender != 0, function ($query){
            $query->where('gender', $this->gender);
        })
        ->when($this->nationality != 0, function ($query) {
            $query->where('nationality', $this->nationality);
        })
        ->when($this->religious_affiliation != null, function ($query)  {
            $query->where('religious_affiliation', 'LIKE', '%'.$this->religious_affiliation.'%');
        })
        ->when($this->civil_status != 0, function ($query) {
            $query->where('civil_status', $this->civil_status);
        })
        ->when($this->work_type != 0, function ($query){
            $query->where('work_type', $this->work_type);
        })
        ->when($this->station_id != 0, function ($query) {
            $query->where('station_id', $this->station_id);
        })
        ->when($this->designation_id != 0, function ($query) {
            $query->where('designation_id', $this->designation_id);
        })
        ->when($this->is_active != '', function ($query){
            $query->where('is_active', $this->is_active);
        })
        ->when($this->from_join_date != '' && $this->to_join_date != '', function ($query) {
            $query->whereBetween('join_date', [$this->from_join_date, $this->to_join_date]);
        })
        ->when($this->from_dob != '' && $this->to_dob != '', function ($query) {
            $query->whereBetween('birthday', [$this->from_dob , $this->to_dob]);
        })
        ->when($this->birth_place != '', function ($query){
            $query->where('birth_place', 'LIKE', '%'.$this->birth_place.'%');
        })
        ->when($this->blood_type != 0, function ($query){
            $query->where('blood_type', $this->blood_type);
        })
        ->when($this->address != '', function ($query) {
            $query->where('address', 'LIKE', '%'.$this->address.'%');
        })
        ->when($this->title != 0, function ($query){
            $query->where('title', $this->title);
        })
        ->when($this->project_id != 0, function ($query){
            $query->whereHas('projects',function($query){
                $query->where('project_id',$this->project_id);
            });
        })
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
        $data['employees'] = $this->filterEmployees()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        $data['designations'] = Designation::where('is_active',true)->get();
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        $data['projects'] = Project::get();

        return view('livewire.human-resource.employee-data.employees-list-component',$data);
    }
}
