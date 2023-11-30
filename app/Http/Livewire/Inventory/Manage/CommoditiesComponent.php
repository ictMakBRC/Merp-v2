<?php

namespace App\Http\Livewire\Inventory\Manage;

use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Settings\InvCategory;
use App\Models\Inventory\Settings\InvUnitOfMeasure;
use Livewire\WithPagination;
use Livewire\Component;

class CommoditiesComponent extends Component
{
  use WithPagination;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'name';

  public $orderAsc = true;

  public $user_id;

  public $edit_id;

  public $is_active;

  public $delete_id;

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

  public $item_code;

  protected $paginationTheme = 'bootstrap';

  public $createNew = false;

  public $toggleForm = false;

  public $filter = false;

  public function export()
  {

  }

  public function refresh()
  {
    return redirect(request()->header('Referer'));
  }

  public function createNewInv()
  {
    $this->dispatchBrowserEvent('show-modal');
    $this->resetInputs();
    $this->toggleForm = false;
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
  }

  public function storeData()
  {
    $this->validate([
    'name' => 'required|unique:inv_items,name',
    'category_id' => 'required',
    'uom_id' => 'required',
    'max_qty' => 'required|numeric',
    'min_qty' => 'required|numeric',
    'item_code' => 'required|unique:inv_items,item_code',
    ]);

    $commodity = new InvItem();
    $commodity->name = $this->name;
    $commodity->category_id = $this->category_id;
    $commodity->uom_id = $this->uom_id;
    $commodity->max_qty = $this->max_qty;
    $commodity->min_qty = $this->min_qty;
    $commodity->description = $this->description;
    // $commodity->is_active = $this->is_active;
    $commodity->expires = $this->expires??0;
    $commodity->item_code = $this->item_code;
    $commodity->save();

    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Commodity successfully added!']);
  }


  public function editdata($id)
  {
    $value = InvItem::where('id', $id)->first();
    $this->name = $value->name;
    $this->category_id = $value->category_id;
    $this->uom_id = $value->uom_id;
    $this->cost_price = $value->cost_price;
    $this->inv_uom_id = $value->inv_uom_id;
    $this->max_qty = $value->max_qty;
    $this->min_qty = $value->min_qty;
    $this->item_code = $value->item_code;
    $this->expires = $value->expires;
    $this->description = $value->description;
    $this->is_active = $value->is_active;
    $this->edit_id = $id;

    $this->dispatchBrowserEvent('show-modal');
    $this->toggleForm = true;

  }


  public function updateData()
  {
    $this->validate([
    'name' => 'required|unique:inv_items,name,'.$this->edit_id.'',
    'category_id' => 'required',
    'uom_id' => 'required',
    'max_qty' => 'required|numeric',
    'min_qty' => 'required|numeric',
    'item_code' => 'required|unique:inv_items,item_code,'.$this->edit_id.'',
    ]);

    $value = InvItem::find($this->edit_id);
    $value->name = $this->name;
    $value->category_id = $this->category_id;
    $value->uom_id = $this->uom_id;
    $value->cost_price = $this->cost_price;
    $value->max_qty = $this->max_qty;
    $value->min_qty = $this->min_qty;
    $value->item_code = $this->item_code;
    $value->expires = $this->expires;
    $value->description = $this->description;
    $value->is_active = $this->is_active;
    $value->update();

    $this->is_update = 'false';
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value updated successfully!']);
  }

  public function close()
  {
    $this->dispatchBrowserEvent('close-modal');
  }
  public function mainQuery()
  {
    return InvItem::search($this->search)
    ->when($this->category_id, function ($query) {
      $query->where('category_id',$this->category_id);
    })
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

  }

  public function render()
  {
    $data['commodities'] = $this->mainQuery()->paginate($this->perPage);

    $data['categories'] = InvCategory::orderBy('name', 'asc')->get();
    $data['uoms'] = InvUnitOfMeasure::orderBy('name', 'asc')->get();

    return view('livewire.inventory.manage.commodities-component',$data);
  }
}
