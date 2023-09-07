<?php

namespace App\Http\Livewire\Inventory\Manage;

use App\Models\inventory\invItems;
use App\Models\inventory\invStores;
use App\Models\inventory\invSubunits;
use App\Models\inventory\invUom;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class ItemsComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'item_name';

    public $orderAsc = true;

    public $item_name;

    public $inv_subunit_id;

    public $cost_price;

    public $inv_uom_id;

    public $supplier_id;

    public $max_qty;

    public $min_qty;

    public $inv_store_id;

    public $description;

    public $date_added;

    public $expires;

    public $item_code;

    public $user_id;

    public $edit_id;

    public $is_active;

    public $delete_id;

    public $is_update = 'false';

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
            'item_name' => 'required|unique:inv_items,item_name',
            'inv_subunit_id' => 'required',
            'cost_price' => 'required|numeric',
            'inv_uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'item_code' => 'required|unique:inv_items,item_code',
            'description' => 'required',
            'date_added' => 'required',
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
            'item_name' => 'required|unique:inv_items,item_name',
            'inv_subunit_id' => 'required',
            'cost_price' => 'required|numeric',
            'inv_uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'item_code' => 'required|unique:inv_items,item_code',
            'description' => 'required',
            'date_added' => 'required',
            // 'is_active' => 'required',
        ]);

        $value = new invItems();
        $value->item_name = $this->item_name;
        $value->inv_subunit_id = $this->inv_subunit_id;
        $value->cost_price = $this->cost_price;
        $value->inv_uom_id = $this->inv_uom_id;
        $value->supplier_id = $this->supplier_id != '' ? $this->supplier_id : null;
        $value->max_qty = $this->max_qty;
        $value->min_qty = $this->min_qty;
        $value->item_code = $this->item_code;
        $value->expires = $this->expires != '' ? $this->expires : 'Off';
        $value->description = $this->description;
        $value->date_added = $this->date_added;
        $value->user_id = auth()->user()->id;
        $value->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value created successfully!']);
    }

    public function editdata($id)
    {
        $value = invItems::where('id', $id)->first();
        $this->item_name = $value->item_name;
        $this->inv_subunit_id = $value->inv_subunit_id;
        $this->cost_price = $value->cost_price;
        $this->inv_uom_id = $value->inv_uom_id;
        $this->supplier_id = $value->supplier_id;
        $this->max_qty = $value->max_qty;
        $this->min_qty = $value->min_qty;
        $this->item_code = $value->item_code;
        $this->expires = $value->expires;
        $this->description = $value->description;
        $this->is_active = $value->is_active;
        $this->is_update = 'true';
        $this->edit_id = $id;
        // $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset([
            'item_name',
            'inv_subunit_id',
            'cost_price',
            'inv_uom_id',
            'supplier_id',
            'max_qty',
            'min_qty',
            'inv_store_id',
            'description',
            'date_added',
            'is_active',
            'expires',
            'item_code',
        ]);
        $this->is_update = 'false';
    }

    public function updateData()
    {
        $this->validate([
            'item_name' => 'required|unique:inv_items,item_name,'.$this->edit_id.'',
            'inv_subunit_id' => 'required',
            'cost_price' => 'required|numeric',
            'inv_uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'item_code' => 'required|unique:inv_items,item_code,'.$this->edit_id.'',
            'description' => 'required',
            'date_added' => 'required',
            'is_active' => 'required',
        ]);

        $value = invItems::find($this->edit_id);
        $value->item_name = $this->item_name;
        $value->inv_subunit_id = $this->inv_subunit_id;
        $value->cost_price = $this->cost_price;
        $value->inv_uom_id = $this->inv_uom_id;
        $value->supplier_id = $this->supplier_id != '' ? $this->supplier_id : null;
        $value->max_qty = $this->max_qty;
        $value->min_qty = $this->min_qty;
        $value->item_code = $this->item_code;
        $value->expires = $this->expires != '' ? $this->expires : 'Off';
        $value->description = $this->description;
        $value->date_added = $this->date_added;
        $value->is_active = $this->is_active;
        $value->update();

        $this->is_update = 'false';
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
            $value = invItems::where('id', $this->delete_id)->first();
            $value->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value deleted successfully!']);
        } catch(\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'value can not be deleted!']);
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
        $this->resetInputs();
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $data['values'] = invItems::search($this->search)->with('parentcategory')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        $data['subcat'] = invSubunits::orderBy('subunit_name', 'asc')->get();
        $data['uoms'] = invUom::orderBy('uom_name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('supplier_name', 'asc')->get();
        $data['stores'] = invStores::orderBy('store_name', 'asc')->get();

        return view('livewire.inventory.manage.items-component', $data)->layout('inventdashboard.layouts.app');
    }
}
