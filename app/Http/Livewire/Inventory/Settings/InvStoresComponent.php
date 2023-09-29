<?php

namespace App\Http\Livewire\Inventory\Settings;

use App\Models\Inventory\Settings\InvStore;
use Livewire\Component;
use Livewire\WithPagination;

class InvStoresComponent extends Component
{
    use WithPagination;
    
    //Filters
    public $from_date;

    public $to_date;

    public $storeIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $description;

    public $location;

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
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);
    }

    public function storeInvStore()
    {
        $this->validate([
            'name' => 'required|string|unique:inv_stores',
            'is_active' => 'required|numeric',
            'location' => 'required|string',
            'description' => 'nullable|string',

        ]);

        $store = new InvStore();
        $store->name = $this->name;
        $store->is_active = $this->is_active;
        $store->location = $this->location;
        $store->description = $this->description;
        $store->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'store created successfully!']);
    }

    public function editData(InvStore $store)
    {
        $this->edit_id = $store->id;
        $this->name = $store->name;
        $this->location = $store->location;
        $this->is_active = $store->is_active;
        $this->description = $store->description;
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

    public function updateInvStore()
    {
        $this->validate([
            'name' => 'required|unique:inv_stores,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $store = InvStore::find($this->edit_id);
        $store->name = $this->name;
        $store->location = $this->location;
        $store->is_active = $this->is_active;
        $store->description = $this->description;
        $store->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'store updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->storeIds) > 0) {
            // return (new storesExport($this->storeIds))->download('stores_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No stores selected for export!',
            ]);
        }
    }

    public function filterStores()
    {
        $stores = InvStore::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->storeIds = $stores->pluck('id')->toArray();

        return $stores;
    }

    public function render()
    {
        $data['stores'] = $this->filterStores()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
  
        return view('livewire.inventory.settings.stores-component', $data);
    }
}
