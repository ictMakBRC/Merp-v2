<?php

namespace App\Http\Livewire\Inventory\Manage;

use Livewire\Component;
use App\Exports\Inventory\ExportDepartmentItems;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Item\InvDepartmentItem;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentItemsComponent extends Component
{
  public $brand, $department_id, $item_id;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'department_id';

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

  public function refresh()
  {
    return redirect(request()->header('Referer'));
  }

  public function export()
  {
    $this->exportData = $this->mainQuery()->pluck('inv_department_items.id')->toArray();

    return Excel::download(new ExportDepartmentItems($this->exportData), 'department-items-'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
  }

  public function confirmDelete($id)
  {
    $this->delete_id = $id;
    $this->dispatchBrowserEvent('delete-modal');
  }

  public function deleteEntry()
  {
    $dept_item = InvDepartmentItem::findOrFail($this->delete_id);
    $dept_item->delete();

    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Entry successfully deleted!']);
  }

  public function editdata(InvDepartmentItem $dept_item)
  {
    $this->edit_id = $dept_item->id;
    $this->brand = $dept_item->brand;
    $this->item_id = $dept_item->inv_item_id;
    $this->department_id = $dept_item->department_id;
    $this->is_active = $dept_item->is_active;
    $this->toggleForm = true;
  }

  public function updateData()
  {
    $this->validate([
    'department_id' => 'required',
    'item_id' => 'required',
    'brand' => 'required',
    ]);

    $dept_item = InvDepartmentItem::findOrFail($this->edit_id);
    $dept_item->brand = $this->brand;
    $dept_item->inv_item_id = $this->item_id;
    $dept_item->department_id = $this->department_id;
    $dept_item->is_active = $this->is_active;
    $dept_item->update();

    $this->close();
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Department Item successfully updated!']);
  }

  public function storeData()
  {
    $check = $this->mainQuery()->where('inv_item_id', $this->item_id)
    ->where('department_id',$this->department_id)
    ->where('brand',$this->brand)->exists();

    if ($check) {
      $this->dispatchBrowserEvent('swal:modal', [
      'type' => 'warning',
      'message' => 'Duplication',
      'text' => 'Commodity already tagged to the selected department',
      ]);

    } else {
      $this->validate([
      'department_id' => 'required',
      'item_id' => 'required',
      'brand' => 'required',
      ]);

      $unitable = Department::find($this->department_id);
      $dept_item = new InvDepartmentItem();
      $dept_item->brand = $this->brand;
      $dept_item->inv_item_id = $this->item_id;
      $dept_item->department_id = $this->department_id;
      $dept_item->unitable()->associate($unitable);
      $dept_item->save();

      $this->close();
      $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Department Item successfully added!']);
    }
  }

  public function resetInputs()
  {
    $this->reset([
    'brand',
    'item_id',
    'department_id',
    ]);
  }

  public function mainQuery()
  {
    return InvDepartmentItem::search($this->search)
    ->when($this->department_id, function ($query) {
      $query->where('department_id',$this->department_id);
    })
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

  }

  public function render()
  {
    $data['dept_items'] = $this->mainQuery()->paginate($this->perPage);

    $data['departments'] = Department::orderBy('name', 'asc')->get();
    $data['items'] = InvItem::get();

    return view('livewire.inventory.manage.department-items-component',$data);
  }
}
