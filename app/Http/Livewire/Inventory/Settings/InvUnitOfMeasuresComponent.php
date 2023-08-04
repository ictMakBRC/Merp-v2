<?php

namespace App\Http\Livewire\Inventory\Settings;

use App\Models\Inventory\Settings\InvUnitOfMeasure;
use Livewire\Component;
use Livewire\WithPagination;

class InvUnitOfMeasuresComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $uomIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $description;

    public $packaging_type;

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
            'is_active' => 'required|integer',
            'packaging_type' => 'required|string',
            'description' => 'nullable|string',
        ]);
    }

    public function storeUom()
    {
        $this->validate([
            'name' => 'required|string|unique:inv_unit_of_measures',
            'is_active' => 'required|numeric',
            'packaging_type' => 'required|string',
            'description' => 'nullable|string',

        ]);

        $uom = new InvUnitOfMeasure();
        $uom->name = $this->name;
        $uom->is_active = $this->is_active;
        $uom->packaging_type = $this->packaging_type;
        $uom->description = $this->description;
        $uom->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'uom created successfully!']);
    }

    public function editData(InvUnitOfMeasure $uom)
    {
        $this->edit_id = $uom->id;
        $this->name = $uom->name;
        $this->packaging_type = $uom->packaging_type;
        $this->is_active = $uom->is_active;
        $this->description = $uom->description;
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

    public function updateUom()
    {
        $this->validate([
            'name' => 'required|unique:inv_unit_of_measures,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'packaging_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $uom = InvUnitOfMeasure::find($this->edit_id);
        $uom->name = $this->name;
        $uom->packaging_type = $this->packaging_type;
        $uom->is_active = $this->is_active;
        $uom->description = $this->description;
        $uom->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'uom updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->uomIds) > 0) {
            // return (new uomsExport($this->uomIds))->download('uoms_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No uoms selected for export!',
            ]);
        }
    }

    public function filterUoms()
    {
        $uoms = InvUnitOfMeasure::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->uomIds = $uoms->pluck('id')->toArray();

        return $uoms;
    }

    public function render()
    {
        $data['uoms'] = $this->filterUoms()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.inventory.settings.inv-unit-of-measures-component',$data);
    }
}
