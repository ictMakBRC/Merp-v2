<?php

namespace App\Http\Livewire\Finance\Accounting;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Settings\FmsChartOfAccountsSubType;
use App\Models\Finance\Settings\FmsChartOfAccountsType;
use App\Models\Finance\Settings\FmsFmsChartOfAccountType;
use App\Models\Finance\Settings\FmsFmsChartOfAccountSubType;

class ChartOfAccountsComponent extends Component
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

    public $sub_account_type;

    public $account_type;

    public $is_active;
    public $is_budget;

    public $mode = 'add';

    public $delete_id;

    public $edit_id;


    public $description;

    public $is_sub = false;
    public $sub_accounts = [];
    
    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $f_account_type;

    public $filter = false;
    public function export()
    {
        // return (new COAsExport())->download('COAs.xlsx');
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
            'name' => 'required|unique:fms_chart_of_accounts',
            'code' => 'unique:fms_chart_of_accounts',
            // 'is_active' => 'required|numeric',
            'account_type' => 'required|numeric',
            'sub_account_type' => 'required|numeric',

        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:fms_chart_of_accounts',
            'code' => 'required|unique:fms_chart_of_accounts',
            'is_budget' => 'required|numeric',
            'account_type' => 'required|numeric',
            'sub_account_type' => 'required|numeric',

        ]);
        $account = new FmsChartOfAccount();
        $account->name = $this->name;
        $account->code = $this->code == '' ? '0' : $this->code;
        $account->account_type = $this->account_type;
        $account->sub_account_type = $this->sub_account_type;
        $account->parent_account = $this->parent_account;
        $account->primary_balance = $this->primary_balance??0;
        $account->bank_balance = $this->bank_balance??0;
        $account->as_of = date('Y-m-d');
        $account->description = $this->description;
        $account->is_active = isset($this->is_active) ? 1 : 0;
        $account->is_budget = isset($this->is_budget) ? 1 : 0;
        $account->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'COA created successfully!']);
    }

    public function editdata(FmsChartOfAccount $account)
    {
        $this->edit_id = $account->id;
        $this->name = $account->name;
        $this->code = $account->code;
        $this->account_type = $account->account_type;
        $this->parent_account = $account->parent_account;
        $this->primary_balance =$account->primary_balance;
        $this->bank_balance = $account->bank_balance;
        $this->as_of = $account->as_of;
        $this->sub_account_type = $account->sub_account_type;
        $this->description = $account->description;
        $this->is_budget = $account->is_budget;
        $this->is_active = $account->is_active;
        $this->mode = 'edit';
        //$this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'code',
            'account_type',
            'sub_account_type',
            'is_active',
            'description',
            'parent_account',
            'primary_balance',
            'bank_balance',
            'as_of',
            'is_budget'
        ]);
        $this->mode = 'add';
        $this->is_sub = false;
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:fms_chart_of_accounts,name,'.$this->edit_id.'',
            'code' => 'required|unique:fms_chart_of_accounts,code,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'is_budget' => 'required|numeric',
            'account_type' => 'required|numeric',
            'sub_account_type' => 'required|numeric',
        ]);

        $account = FmsChartOfAccount::find($this->edit_id);
        $account->name = $this->name;
        $account->code = $this->code;
        $account->account_type = $this->account_type;
        $account->parent_account = $this->parent_account;
        // $account->primary_balance = $this->primary_balance;
        // $account->bank_balance = $this->bank_balance;
        // $account->as_of = $this->as_of;
        $account->sub_account_type = $this->sub_account_type;
        $account->description = $this->description;
        $account->is_active = $this->is_active;
        $account->is_budget = $this->is_budget;
        $account->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'COA updated successfully!']);
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
        ->with(['type', 'subType','parent']) ->when($this->f_account_type != '', function ($query) {
            $query->where('account_type',  $this->f_account_type);
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['types'] = FmsChartOfAccountsType::all();
        
        $data['sub_types'] = FmsChartOfAccountsSubType::where('type_id', $this->account_type)->get();
             
        if($this->is_sub){
            $this->sub_accounts = FmsChartOfAccount::where(['is_active'=>1,'account_type'=>$this->account_type])->with(['type'])
            ->orderBy('name', 'asc')->get();
        }
        return view('livewire.finance.accounting.fms-chart-of-accounts-component', $data);
    }
}
