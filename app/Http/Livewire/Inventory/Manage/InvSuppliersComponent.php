<?php

namespace App\Http\Livewire\Inventory\Manage;
use App\Models\Inventory\Settings\InvSupplier;
use Livewire\WithPagination;

use Livewire\Component;

class InvSuppliersComponent extends Component
{
  use WithPagination;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'name';

  public $orderAsc = true;

  public $edit_id;

  public $is_active;

  public $delete_id;

  public $name;

  public $address;

  public $contact;

  public $email;

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
    $this->createNew = true;
  }

  public function storeData()
  {
    $this->validate([
        'name' => 'required|unique:inv_suppliers,name',
        'email' => 'email'
    ]);

    $supplier = new InvSupplier;
    $supplier->name = $this->name;
    $supplier->contact = $this->contact;
    $supplier->email = $this->email;
    $supplier->address = $this->address;

    $supplier->save();
    $this->resetInputs();
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Supplier successfully added']);
  }

  public function editdata(InvSupplier $supplier)
  {
    $this->edit_id = $supplier->id;
    $this->name = $supplier->name;
    $this->contact = $supplier->contact;
    $this->email = $supplier->email;
    $this->address = $supplier->address;

    $this->createNew = false;
    $this->dispatchBrowserEvent('show-modal');
  }

    public function updateData()
    {
      $this->validate([
          'email' => 'email',
          'name' => 'required|unique:inv_suppliers,name,'.$this->edit_id
      ]);

      $supplier = InvSupplier::findOrFail($this->edit_id);
      $supplier->name = $this->name;
      $supplier->contact = $this->contact;
      $supplier->email = $this->email;
      $supplier->address = $this->address;

      $supplier->update();
      $this->close();
      $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Supplier successfully updated']);
    }

public function close()
{
  $this->resetInputs();
  $this->dispatchBrowserEvent('close-modal');
}
  public function resetInputs()
  {
    $this->reset([
    'name',
    'contact',
    'address',
    'email',
    ]);
  }

  public function mainQuery()
  {
    return InvSupplier::search($this->search)
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

  }

  public function render()
  {
    $data['suppliers'] = $this->mainQuery()->paginate($this->perPage);
    return view('livewire.inventory.manage.inv-suppliers-component',$data);
  }
}
