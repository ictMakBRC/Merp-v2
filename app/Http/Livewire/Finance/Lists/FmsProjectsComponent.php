<?php

namespace App\Http\Livewire\Finance\Lists;

use App\Models\Grants\Project\Project;
use Livewire\Component;
use Livewire\WithPagination;

class FmsProjectsComponent extends Component
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
    
    public $project_category;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $active_unit;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectUnit($id)
    {
        $this->active_unit = $id;
        if (session()->has('unit')) {
            session()->forget('unit');
        }
        $this->validate([
            'active_unit' => 'required',
        ]);
        $unit = Project::where('id', $this->active_unit)->first();
        if ($unit) {
            session(['unit' => $unit->name]);
            session(['unit_type' => 'project']);
            session(['unit_id' => $unit->id]);
            if (session()->has('unit')) {
                return to_route('finance-dashboard_unit', [session('unit_id'), session('unit_type')]);
            }
        }
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

    public function filterProjects()
    {
        $projects = Project::search($this->search)->with('principalInvestigator')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        // $this->projectIds = $projects->pluck('id')->toArray();

        return $projects;
    }

    public function render()
    {
        $data['projects'] = $this->filterProjects()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.lists.fms-projects-component', $data);
    }
}
