<?php

namespace App\Http\Livewire\Finance\Ledger;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsLedgerAccount;

class FmsLedgerAccountsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $accountIds;

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
    public $name;
    public $description;
    public $account_number;
    public $department_id;
    public $project_id;
    public $primary_balance;
    public $bank_balance;
    public $as_of;
    public $is_active;
    public $entry_type ='Department';

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'description',
            'account_number',
            'department_id',
            'project_id',
            'primary_balance',
            'bank_balance',
            'as_of',
            'is_active',
        ]);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string|unique:fms_ledger_accounts',
            'is_active' => 'required|numeric',
            'account_number' => 'required|unique:fms_ledger_accounts',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'primary_balance' => 'required|numeric',
            'bank_balance' => 'required|numeric',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->accountIds) > 0) {
            // return (new accountSubTypeExport($this->accountIds))->download('accountSubType_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No accountSubType selected for export!',
            ]);
        }
    }

    public function storeAccount()
    {

        $this->validate([
            'name' => 'required|string|unique:fms_ledger_accounts',
            'is_active' => 'required|numeric',
            'account_number' => 'required|unique:fms_ledger_accounts',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'primary_balance' => 'required',
            'bank_balance' => 'required',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'entry_type'=>'required'

        ]);
        $record = null;
        if ($this->entry_type == 'Project'){
            $this->validate([               
                'project_id' => 'required|integer',    
            ]);
            $this->department_id = null;
            $record = FmsLedgerAccount::where('project_id',$this->project_id)->first();
        }elseif($this->entry_type == 'Department'){
            $this->validate([               
                'department_id' => 'required|integer',    
            ]);
            $this->project_id = null;
            $record = FmsLedgerAccount::where('department_id',$this->department_id)->first();
        }

        if($record){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'the selected unit has an account!',
            ]);
            return false;
        }

        $primary_balance = (float) str_replace(',', '', $this->primary_balance);
        $bank_balance = (float) str_replace(',', '', $this->bank_balance);

        $account = new FmsLedgerAccount();
        $account->name = $this->name;
        $account->is_active = $this->is_active;
        $account->account_number = $this->account_number;
        $account->department_id = $this->department_id;
        $account->project_id = $this->project_id;
        $account->primary_balance = $primary_balance;
        $account->bank_balance = $bank_balance;
        $account->as_of = $this->as_of;
        $account->is_active = $this->is_active;
        $account->description = $this->description;
        $account->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'account created successfully!']);
    }

    public function updateAccount()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_ledger_accounts,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'account_number' => 'required|unique:fms_ledger_accounts,account_number,'.$this->edit_id.'',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'primary_balance' => 'required',
            'bank_balance' => 'required',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        
        $primary_balance = (float) str_replace(',', '', $this->primary_balance);
        $bank_balance = (float) str_replace(',', '', $this->bank_balance);

        $account = FmsLedgerAccount::where('id',$this->edit_id)->first();
        $account->name = $this->name;
        $account->is_active = $this->is_active;
        $account->account_number = $this->account_number;
        $account->primary_balance = $primary_balance;
        $account->bank_balance = $bank_balance;
        $account->as_of = $this->as_of;
        $account->is_active = $this->is_active;
        $account->description = $this->description;
        $account->update();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'account created successfully!']);
    }

    public function editData(FmsLedgerAccount $account)
    {
        $this->edit_id = $account->id;
        $this->name = $account->name;
        $this->is_active = $account->is_active;
        $this->account_number = $account->account_number;
        $this->department_id = $account->department_id;
        $this->project_id = $account->project_id;
        $this->primary_balance = $account->primary_balance;
        $this->bank_balance = $account->bank_balance;
        $this->as_of = $account->as_of;
        $this->is_active = $account->is_active;
        $this->description = $account->description;
        $this->createNew = true;
        $this->toggleForm = true;
        if ($this->project_id != null){
            $this->entry_type == 'Project';
        }elseif($this->department_id != null){
            $this->entry_type == 'Department';
        }
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function filterAccount()
    {
        $accountSubType = FmsLedgerAccount::search($this->search)->with(['project', 'department'])
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->accountIds = $accountSubType->pluck('id')->toArray();

        return $accountSubType;
    }

    public function render()
    {
        $data['departments'] = Department::where('is_active', 1)->get();
        $data['projects'] = Project::get();
        $data['accounts'] = $this->filterAccount()->where('is_active', 1)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.finance.ledger.fms-ledger-accounts-component', $data);
    }
}
