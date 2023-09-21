<?php

namespace App\Http\Livewire\HumanResource\Settings;

use App\Models\HumanResource\EmployeeData\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Settings\Department;

class DepartmentsComponent extends Component
{
   
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $departmentIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active = 1;

    public $description;

    public $totalMembers;

    public $delete_id;

    public $edit_id;
    
    public $parent_department;

    public $type;

    public $prefix;

    public $supervisor;

    public $asst_supervisor;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'prefix' => 'required|string',
            'parent_department' => 'nullable|integer',
            'supervisor' => 'nullable|integer',
            'asst_supervisor' => 'nullable|integer',
        ]);
    }

    public function storeDepartment()
    {
        $this->validate([
            'name' => 'required|string|unique:departments',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'prefix' => 'required|string',
            'parent_department' => 'nullable|integer',
            'supervisor' => 'nullable|integer',
            'asst_supervisor' => 'nullable|integer',

        ]);

        $department = new Department();
        $department->name = $this->name;
        $department->is_active = $this->is_active;
        $department->description = $this->description;
        $department->supervisor = $this->supervisor??null;
        $department->asst_supervisor = $this->asst_supervisor??null;
        $department->type = $this->type;
        $department->prefix = $this->prefix;
        $department->parent_department = $this->parent_department??null;
        $department->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Department created successfully!']);
    }

    public function editData(Department $department)
    {
        $this->edit_id = $department->id;
        $this->name = $department->name;
        $this->is_active = $department->is_active;
        $this->description = $department->description;
        $this->supervisor = $department->supervisor;
        $this->asst_supervisor = $department->asst_supervisor;
        $this->type = $department->type;
        $this->prefix = $department->prefix;
        $this->parent_department = $department->parent_department;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'parent_department', 'type', 'description', 'is_active', 'prefix', 'type', 'edit_id']);
    }

    public function updateDepartment()
    {
        $this->validate([
            'name' => 'required|unique:Departments,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'prefix' => 'required|string',
            'parent_department' => 'nullable|integer',
            'supervisor' => 'nullable|integer',
            'asst_supervisor' => 'nullable|integer',
        ]);

        $department = Department::find($this->edit_id);
        $department->name = $this->name;
        $department->is_active = $this->is_active;
        $department->description = $this->description;
        $department->supervisor = $this->supervisor;
        $department->asst_supervisor = $this->asst_supervisor;
        $department->type = $this->type;
        $department->prefix = $this->prefix;
        $department->parent_department = $this->parent_department;
        $department->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Department updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->departmentIds) > 0) {
            // return (new DepartmentsExport($this->departmentIds))->download('Departments_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Departments selected for export!',
            ]);
        }
    }

    public function filterDepartments()
    {
        $departments = Department::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->departmentIds = $departments->pluck('id')->toArray();

        return $departments;
    }

    public function render()
    {
        $data['departments'] = $this->filterDepartments()->With(['parent'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
            $data['parent_departments'] = Department::all();
            $data['department_heads'] = Employee::where('is_active',1)->get();
        return view('livewire.human-resource.settings.departments-component',$data)->layout('layouts.app');
    }
}
