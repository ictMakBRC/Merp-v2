<?php

namespace App\Http\Livewire\HumanResource\GrievanceTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Settings\Designation;

class Template extends Component
{

    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $designationIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $description;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

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
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
    }

    public function storeDesignation()
    {
        $this->validate([
            'name' => 'required|string|unique:Designations',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        $designation = new Designation();
        $designation->name = $this->name;
        $designation->is_active = $this->is_active;
        $designation->description = $this->description;
        $designation->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Designation created successfully!']);
    }

    public function editData(Designation $designation)
    {
        $this->edit_id = $designation->id;
        $this->name = $designation->name;
        $this->is_active = $designation->is_active;
        $this->description = $designation->description;
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
        $this->reset(['name', 'is_active', 'description']);
    }

    public function updateDesignation()
    {
        $this->validate([
            'name' => 'required|unique:designations,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $designation = Designation::find($this->edit_id);
        $designation->name = $this->name;
        $designation->is_active = $this->is_active;
        $designation->description = $this->description;
        $designation->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Designation updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->DesignationIds) > 0) {
            // return (new DesignationsExport($this->DesignationIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Designations selected for export!',
            ]);
        }
    }

    public function filterDesignations()
    {
        $designations = Designation::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->designationIds = $designations->pluck('id')->toArray();

        return $designations;
    }

    public function render()
    {
        $data['designations'] = $this->filterDesignations()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.settings.designations-component', $data)->layout('layouts.app');
    }
}
