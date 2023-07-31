<?php

namespace App\Http\Livewire\Finance\Accounting;

use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Settings\FmsChartOfAccountsSubType;
use App\Models\Finance\Settings\FmsChartOfAccountsType;
use Livewire\Component;

class FmsChartOfAccountsComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = true;

    public $name;

    public $code;

    public $parent_account;

    public $primary_balance;

    public $bank_balance;

    public $as_of;

    public $sub_type_id;

    public $type_id;

    public $is_active;

    public $mode = 'add';

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $description;

    public $is_sub = false;
    public $sub_accounts = [];
    public function export()
    {
        // return (new CouriersExport())->download('Couriers.xlsx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:chart_of_accounts',
            'code' => 'unique:chart_of_accounts',
            // 'is_active' => 'required|numeric',
            'sub_type_id' => 'required|numeric',
            'type_id' => 'required|numeric',

        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:chart_of_accounts',
            'code' => 'unique:chart_of_accounts',
            // 'is_active' => 'required|numeric',
            'sub_type_id' => 'required|numeric',
            'type_id' => 'required|numeric',

        ]);
        $account = new ChartOfAccounts();
        $account->name = $this->name;
        $account->code = $this->code == '' ? '0' : $this->code;
        $account->type_id = $this->type_id;
        $account->parent_account = $this->parent_account;
        $account->primary_balance = $this->primary_balance;
        $account->bank_balance = $this->bank_balance == '' ? '0' : $this->bank_balance;
        $account->as_of = $this->as_of;
        $account->sub_type_id = $this->sub_type_id;
        $account->description = $this->description;
        $account->is_active = isset($this->is_active) ? 0 : 1;
        $account->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Courier created successfully!']);
    }

    public function editdata(ChartOfAccounts $account)
    {
        $this->edit_id = $account->id;
        $this->name = $account->name;
        $this->code = $account->code;
        $this->type_id = $account->type_id;
        $this->parent_account = $account->parent_account;
        $this->primary_balance =$account->primary_balance;
        $this->bank_balance = $account->bank_balance;
        $this->as_of = $account->as_of;
        $this->sub_type_id = $account->sub_type_id;
        $this->description = $account->description;
        $this->is_active = $account->is_active;
        $this->mode = 'edit';
        //$this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'code',
            'type_id',
            'sub_type_id',
            'is_active',
            'description',
            'parent_account',
            'primary_balance',
            'bank_balance',
            'as_of',
        ]);
        $this->mode = 'add';
        $this->is_sub = false;
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:chart_of_accounts,name,'.$this->edit_id.'',
            // 'is_active' => 'required|numeric',
            'sub_type_id' => 'required|numeric',
            'type_id' => 'required|numeric',
        ]);

        $account = ChartOfAccounts::find($this->edit_id);
        $account->name = $this->name;
        $account->code = $this->code;
        $account->type_id = $this->type_id;
        $account->parent_account = $this->parent_account;
        $account->primary_balance = $this->primary_balance;
        $account->bank_balance = $this->bank_balance;
        $account->as_of = $this->as_of;
        $account->sub_type_id = $this->sub_type_id;
        $account->description = $this->description;
        // $account->is_active = isset($this->is_active) ? 1 : 0;
        $account->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Courier updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }
  
    public function render()
    {
        $data['accounts'] = FmsChartOfAccount::search($this->search)
        ->with(['type', 'subType'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['types'] = FmsChartOfAccountsType::all();
        if($this->type_id != null){
            $data['sub_types'] = FmsChartOfAccountsSubType::where('type_id', $this->type_id)->get();
        }else{
            $data['sub_types'] = [];
        }       
        if($this->is_sub){
            $this->sub_accounts = FmsChartOfAccount::where('is_active',1)->with(['type'])
            ->orderBy('name', 'asc')->get();
        }
        return view('livewire.finance.accounting.fms-chart-of-accounts-component');
    }
}
