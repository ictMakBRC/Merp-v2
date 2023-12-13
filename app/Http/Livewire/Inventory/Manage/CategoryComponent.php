<?php

namespace App\Http\Livewire\Inventory\Manage;

use App\Models\inventory\invSubunits;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'subunit_name';

    public $orderAsc = true;

    public $subunit_name;

    public $edit_id;

    public $is_active;

    public $delete_id;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $validationAttributes = [
        'user_id' => 'facility',
        'is_active' => 'status',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'subunit_name' => 'required|unique:inv_subunits,subunit_name',
            'is_active' => 'required',

        ]);
    }

    public function mount()
    {
        $this->studies = collect();
    }

    public function storeData()
    {
        $this->validate([
            'subunit_name' => 'required|unique:inv_subunits,subunit_name',
        ]);

        $value = new invSubunits();
        $value->subunit_name = $this->subunit_name;
        $value->user_id = auth()->user()->id;
        $value->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value created successfully!']);
    }

    public function editdata($id)
    {
        $value = invSubunits::where('id', $id)->first();
        $this->subunit_name = $value->subunit_name;
        $this->is_active = $value->is_active;
        $this->edit_id = $id;
        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['subunit_name', 'is_active']);
    }

    public function updateData()
    {
        $this->validate([
            'subunit_name' => 'required|unique:inv_subunits,subunit_name,'.$this->edit_id.'',
            'is_active' => 'required',
        ]);
        $value = invSubunits::find($this->edit_id);
        $value->subunit_name = $this->subunit_name;
        $value->is_active = $this->is_active;
        $value->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-modal');
        // if (Auth::user()->hasPermission(['manage-users'])) {

        // } else {
        //     $this->dispatchBrowserEvent('cant-delete', ['type' => 'warning',  'message' => 'Oops! You do not have the necessary permissions to delete this resource!']);
        // }
    }

    public function deleteData()
    {
        try {
            $value = invSubunits::where('id', $this->delete_id)->first();
            $value->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'value can not be deleted!']);
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $values = invSubunits::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.inventory.manage.category-component', compact('values'))->layout('inventdashboard.layouts.app');
    }
}
