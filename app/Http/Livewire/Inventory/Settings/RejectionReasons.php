<?php

namespace App\Http\Livewire\Inventory\Settings;

use App\Models\Inventory\Settings\RejectionReason;
use Livewire\Component;
use Livewire\WithPagination;

class RejectionReasons extends Component
{

  use WithPagination;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'id';

  public $orderAsc = 0;

  public $createNew = false;

  public $toggleForm = false;

  public $rejection_reason;


public function newRejectionReason()
{
  $this->dispatchBrowserEvent('show-modal');
}

public function export()
{

}

public function close()
{
  $this->resetInputs();
  $this->dispatchBrowserEvent('close-modal');
}
public function resetInputs()
{
  $this->reset([
    'rejection_reason'
  ]);
}
public function storeData()
{
  $this->validate([
  'rejection_reason' => 'required',
  ]);

  $reason = new RejectionReason();
  $reason->name = $this->rejection_reason;
  $reason->created_by = \Auth::user()->id;
  $reason->save();

  $this->resetInputs();
  $this->dispatchBrowserEvent('alert',['type' => 'success',  'message' => 'Rejection reason successfully added']);

}

  public function mainQuery()
  {
    return RejectionReason::search($this->search)
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

  }
  public function render()
  {
    $data['rejection_reasons'] = $this->mainQuery()->paginate($this->perPage);

    return view('livewire.inventory.settings.rejection-reasons',$data);
  }
}
