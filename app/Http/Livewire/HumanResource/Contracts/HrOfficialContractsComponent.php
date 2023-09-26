<?php

namespace App\Http\Livewire\HumanResource\Contracts;

use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;
use Livewire\Component;
use Livewire\WithPagination;

class HrOfficialContractsComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $currencyIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $system_default=0;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mainQuery()
    {
        $currencies = OfficialContract::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->currencyIds = $currencies->pluck('id')->toArray();

        return $currencies;
    }

    public function render()
    {
        $data['contracts'] = $this->mainQuery()->with('employee')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
  
     
        return view('livewire.human-resource.contracts.hr-official-contracts-component',$data);
    }
}
