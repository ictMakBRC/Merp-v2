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
    $this->toggleForm = false;
  }

  public function resetInputs()
  {
    $this->reset([
    'name',
    'contact',
    'address',
    'email',
    'is_active',
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
