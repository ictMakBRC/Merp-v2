<?php

namespace App\Http\Livewire\Inventory\Manage;

use App\Models\Inventory\InvStockDocument;
use App\Models\inventory\invSubunits;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class StockDocumentsComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'created_at';

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
        $values = InvStockDocument::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.inventory.manage.stock-documents-component', compact('values'))->layout('inventdashboard.layouts.app');
    }
}
