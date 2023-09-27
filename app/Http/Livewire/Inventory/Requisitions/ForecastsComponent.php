<?php

namespace App\Http\Livewire\Inventory\Requisitions;

use Livewire\Component;
use App\Services\GeneratorService;
use Livewire\WithPagination;

class ForecastsComponent extends Component
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

    public function render()
    {
        return view('livewire.inventory.requisitions.forecasts-component');
    }
}
