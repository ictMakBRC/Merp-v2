<?php

namespace App\Http\Livewire\Inventory\Item;

use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Settings\InvCategory;
use App\Models\Inventory\Settings\InvUnitOfMeasure;
use App\Services\GeneratorService;
use Livewire\Component;
use Livewire\WithPagination;

class InvItemsComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $customerIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;
    
    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $name;
    public $category_id;
    public $cost_price;
    public $uom_id;
    public $max_qty;
    public $min_qty;
    public $sku;
    public $description;
    public $date_added;
    public $expires;
    public $is_active=1;
    public $item_code;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:inv_items,name',
            'sku' => 'required|unique:inv_items,sku',
            'category_id' => 'required',
            'cost_price' => 'required|numeric',
            'uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'description' => 'required',

        ]);
    }

    public function storeItem()
    {
        $this->validate([
            'name' => 'required|unique:inv_items,name',
            'sku' => 'required|unique:inv_items,sku',
            'category_id' => 'required',
            'cost_price' => 'required|numeric',
            'uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'description' => 'required',
            'is_active' => 'required',
        ]);

        $item = new InvItem();
        $item->name = $this->name;
        $item->category_id = $this->category_id;
        $item->cost_price = $this->cost_price;
        $item->uom_id = $this->uom_id;
        $item->max_qty = $this->max_qty;
        $item->min_qty = $this->min_qty;
        $item->sku = $this->sku;
        $item->description = $this->description;
        $item->is_active = $this->is_active;
        $item->expires = $this->expires;
        $item->item_code = GeneratorService::getNumber(12);
        $item->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'value created successfully!']);
    }

    public function editData($id)
    {
        $item = InvItem::where('id', $id)->first();
        $this->name = $item->name;
        $this->category_id = $item->category_id;
        $this->cost_price = $item->cost_price;
        $this->uom_id = $item->uom_id;
        $this->max_qty = $item->max_qty;
        $this->min_qty = $item->min_qty;
        $this->sku = $item->sku;
        $this->description = $item->description;
        $this->is_active = $item->is_active;
        $this->expires = $item->expires;
        $this->item_code = $item->item_code;
        $this->edit_id = $item->id;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'category_id',
            'cost_price',
            'uom_id',
            'max_qty',
            'min_qty',
            'sku',
            'description',
            'is_active',
            'expires',
            'item_code',
        ]);
        $this->createNew = false;
        $this->toggleForm = false;
    }

    public function updateItem()
    {
        $this->validate([
            'name' => 'required|unique:inv_items,name,' . $this->edit_id . '',
            'name' => 'required|unique:inv_items,sku,' . $this->edit_id . '',
            'category_id' => 'required',
            'cost_price' => 'required|numeric',
            'uom_id' => 'required',
            'max_qty' => 'required|numeric',
            'min_qty' => 'required|numeric',
            'description' => 'required',
        ]);

        $item = InvItem::find($this->edit_id);
        
        $item->name = $this->name;
        $item->category_id = $this->category_id;
        $item->cost_price = $this->cost_price;
        $item->uom_id = $this->uom_id;
        $item->max_qty = $this->max_qty;
        $item->min_qty = $this->min_qty;
        $item->sku = $this->sku;
        $item->description = $this->description;
        $item->expires = $this->expires != '' ? $this->expires : 'No';
        $item->update();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Item updated successfully!']);
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
            $value = InvItem::where('id', $this->delete_id)->first();
            $value->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'value deleted successfully!']);
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'value can not be deleted!']);
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
        $data['items'] = InvItem::search($this->search)->with(['category', 'uom'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        $data['categories'] = InvCategory::orderBy('name', 'asc')->get();
        $data['uoms'] = InvUnitOfMeasure::orderBy('name', 'asc')->get();

        return view('livewire.inventory.item.inv-items-component', $data);
    }
}
