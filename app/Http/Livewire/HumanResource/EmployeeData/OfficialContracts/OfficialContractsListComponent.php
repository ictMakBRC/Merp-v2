<?php

namespace App\Http\Livewire\HumanResource\EmployeeData\OfficialContracts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class OfficialContractsListComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $exportIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $is_active =1;

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

        $this->exportIds = $currencies->pluck('id')->toArray();

        return $currencies;
    }

    public function render()
    {
        $data['contracts'] = $this->mainQuery()->with('employee')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.employee-data.official-contracts.official-contracts-list-component',$data);
    }
}
