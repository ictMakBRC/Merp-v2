<?php

namespace App\Http\Livewire\Inventory\Manage;

use Livewire\Component;
use App\Models\HumanResource\Settings\Department;
use App\Models\inventory\inv_department_Item;
use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Item\InvDepartmentItem;

class DepartmentItemsComponent1 extends Component
{
  public $brand, $department_id, $inv_item_id = [];

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'name';

  public $orderAsc = true;

  public $edit_id;

  public $is_active;

  public $delete_id;

  public $is_update = 'false';

  protected $paginationTheme = 'bootstrap';

  public $createNew = false;

  public $toggleForm = false;

  public $filter = false;

  public function createNew()
  {
    $this->resetInputs();
    $this->dispatchBrowserEvent('show-modal');
  }

  public function close()
  {
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
  }

  public function resetInputs()
  {
    $this->reset([
    'inv_item_id',
    'department_id',

    ]);
    $this->is_update = 'false';
  }

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
    'department_id' => 'required',
    'inv_item_id' => 'required',
    'is_active' => 'required',

    ]);
  }

  public function mount()
  {
    $this->studies = collect();
  }
  // lifecycle hook sometimes we require it for select2
  public function hydrate()
  {
    $this->emit('select2');
  }

  public function storeData()
  {
    $this->validate([
    'department_id' => 'required',
    'inv_item_id' => 'required',
    'brand' => 'required',
    ]);

    $input = [
    'inv_item_id' => $this->inv_item_id,
    'brand' => $this->brand,
    'department_id' => $this->department_id,
    ];
    inv_department_Item::create($input);

    $this->emit('productStore');

    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value created successfully!']);
  }

  public function editdata($id)
  {
    $value = InvItem::where('id', $id)->first();
    $this->inv_item_id = $value->inv_item_id;
    $this->department_id = $value->department_id;

    // $this->dispatchBrowserEvent('edit-modal');
  }


  public function refresh()
  {
    return redirect(request()->header('Referer'));
  }

  public function deleteConfirmation($id)
  {
    $this->delete_id = $id;
    $this->dispatchBrowserEvent('delete-modal');
    $this->dispatchBrowserEvent('swal:confirm', [
    'type' => 'warning',
    'message' => 'Are you sure?',
    'text' => 'If deleted, you will not be able to recover this imaginary file!'
    ]);
    // if (Auth::user()->hasPermission(['manage-users'])) {

    // } else {
    //     $this->dispatchBrowserEvent('cant-delete', ['type' => 'warning',  'message' => 'Oops! You do not have the necessary permissions to delete this resource!']);
    // }
  }

  public function deleteData()
  {
    try {
      $value = inv_department_Item::where('id', $this->delete_id)->first();
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

  public function render()
  {
    $data['dept_items'] = InvDepartmentItem::search($this->search)->with('parentcategory')
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
    ->paginate($this->perPage);

    $data['departments'] = Department::orderBy('name', 'asc')->get();
    $data['items'] = InvItem::get();
    return view('livewire.inventory.item.department-items-component',$data);
  }
}
