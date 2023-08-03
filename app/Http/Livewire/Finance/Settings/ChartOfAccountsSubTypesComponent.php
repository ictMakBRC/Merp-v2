<?php

namespace App\Http\Livewire\Finance\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Settings\FmsChartOfAccountsSubType;
use App\Models\Finance\Settings\FmsChartOfAccountsType;

class ChartOfAccountsSubTypesComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $accountTypeIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $type_id;

    public $is_active =1;

    public $description;

    public $totalMembers;

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

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|string',
            'type_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);
    }

    public function storeAccountType()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_chart_of_accounts_sub_types',
            'is_active' => 'required|numeric',
            'type_id' => 'required|integer',
            'description' => 'nullable|string',

        ]);

        $accountType = new FmsChartOfAccountsSubType();
        $accountType->name = $this->name;
        $accountType->is_active = $this->is_active;
        $accountType->type_id = $this->type_id;
        $accountType->description = $this->description;
        $accountType->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'accountType created successfully!']);
    }

    public function editData(FmsChartOfAccountsSubType $accountType)
    {
        $this->edit_id = $accountType->id;
        $this->name = $accountType->name;
        $this->is_active = $accountType->is_active;
        $this->type_id = $accountType->type_id;
        $this->description = $accountType->description;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active', 'description']);
    }

    public function updateAccountType()
    {
        $this->validate([
            'name' => 'required|unique:fms_chart_of_accounts_sub_types,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'type_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $accountType = FmsChartOfAccountsSubType::find($this->edit_id);
        $accountType->name = $this->name;
        $accountType->is_active = $this->is_active;
        $accountType->type_id = $this->type_id;
        $accountType->description = $this->description;
        $accountType->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'accountType updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->accountTypeIds) > 0) {
            // return (new accountSubTypeExport($this->accountTypeIds))->download('accountSubType_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No accountSubType selected for export!',
            ]);
        }
    }

    public function filteraccountSubType()
    {
        $accountSubType = FmsChartOfAccountsSubType::search($this->search)->with('type')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->accountTypeIds = $accountSubType->pluck('id')->toArray();

        return $accountSubType;
    }

    public function render()
    {
        $data['accountSubTypes'] = $this->filteraccountSubType()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
            $data['types']=FmsChartOfAccountsType::where('is_active', 1)->get();
        return view('livewire.finance.settings.chart-of-accounts-sub-types-component',$data);
    }
}
