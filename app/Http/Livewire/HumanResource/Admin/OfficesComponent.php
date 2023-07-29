<?php

namespace App\Http\Livewire\HumanResource\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Office;

class OfficesComponent extends Component
{
    
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $officeIds;

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
            'is_active' => 'required|string',
            'description' => 'nullable|string',
        ]);
    }

    public function storeOffice()
    {
        $this->validate([
            'name' => 'required|string|unique:Offices',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        $office = new Office();
        $office->name = $this->name;
        $office->is_active = $this->is_active;
        $office->description = $this->description;
        $office->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Office created successfully!']);
    }

    public function editData(Office $office)
    {
        $this->edit_id = $office->id;
        $this->name = $office->name;
        $this->is_active = $office->is_active;
        $this->description = $office->description;
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

    public function updateOffice()
    {
        $this->validate([
            'name' => 'required|unique:Offices,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $office = Office::find($this->edit_id);
        $office->name = $this->name;
        $office->is_active = $this->is_active;
        $office->description = $this->description;
        $office->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Office updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->officeIds) > 0) {
            // return (new OfficesExport($this->OfficeIds))->download('Offices_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Offices selected for export!',
            ]);
        }
    }

    public function filterOffices()
    {
        $offices = Office::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->officeIds = $offices->pluck('id')->toArray();

        return $offices;
    }

    public function render()
    {
        $data['offices'] = $this->filterOffices()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.admin.offices-component',$data)->layout('layouts.app');
    }
}
