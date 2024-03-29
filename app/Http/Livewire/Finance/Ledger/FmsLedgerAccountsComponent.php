<?php

namespace App\Http\Livewire\Finance\Ledger;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\Finance\Settings\FmsChartOfAccountsType;

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
    public $opening_balance;
    public $current_balance;
    public $account_type;
    public $as_of;
    public $rate;
    public $is_active;
    public $currency_id;
    public $entry_type = 'Department';
    public $unit_type = 'department';
    public $unit_id = 0;  public $max_date;
    public $min_date;
    public $active_year;    
    public $fiscal_year;
    public function updatedFiscalYear()
    {
        $this->active_year = FmsFinancialYear::where('id', $this->fiscal_year)->first();
        $this->max_date =$this->active_year->end_date;
        $this->min_date = $this->active_year->start_date;
    }
    public function mount($type)
    {
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $requestable = Project::find($this->unit_id);
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $requestable = Department::find($this->unit_id);
            }
            if ($requestable) {
                $ledger = FmsLedgerAccount::where(['requestable_type' => get_class($requestable), 'requestable_id' => $this->unit_id])->first();
                if ($ledger) {
                    return to_route('finance-ledger_view', $ledger->id);
                }
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }
    }
    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatedDepartmentId()
    {
        $department = Department::where('id', $this->department_id)->first();
        $this->account_number = GeneratorService::ledgerIdentifier();
        $this->currency_id = $department?->currency_id;
        if ($department && $department->name) {

            $this->name = $department->name . ' Ledger Acct';
        }
    }

    public function updatedProjectId()
    {
        $department = Project::where('id', $this->project_id)->first();
        $this->currency_id = $department?->currency_id;
        $this->account_number = GeneratorService::ledgerIdentifier();
        if ($department && $department->project_code) {

            $this->name = $department->project_code . ' Ledger Acct';
        }
    }

    public function updatedEntryType()
    {
        $this->project_id = '';
        $this->department_id = '';
        $this->name = '';
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
            'opening_balance',
            'current_balance',
            'as_of',
            'is_active',
            'currency_id',
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
            'currency_id' => 'required|integer',
            'opening_balance' => 'required|numeric',
            'current_balance' => 'required|numeric',
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

        DB::transaction(function () {
            $this->validate([
                'name' => 'required|string|unique:fms_ledger_accounts',
                'is_active' => 'required|numeric',
                'account_number' => 'required|unique:fms_ledger_accounts',
                'department_id' => 'nullable|integer',
                // 'account_type' => 'required|integer',
                'project_id' => 'nullable|integer',
                'currency_id' => 'required|integer',
                'opening_balance' => 'required',
                'as_of' => 'required|date',
                'is_active' => 'required|numeric',
                'description' => 'nullable|string',
                'entry_type' => 'required',

            ]);
            $record = null;
            $requestable = null;
            if ($this->entry_type == 'Project') {
                $this->validate([
                    'project_id' => 'required|integer',
                ]);
                $this->department_id = null;
                $requestable = Project::find($this->project_id);
                $record = FmsLedgerAccount::where('project_id', $this->project_id)->first();
            } elseif ($this->entry_type == 'Department') {
                $this->validate([
                    'department_id' => 'required|integer',
                ]);
                $this->project_id = null;
                $requestable = Department::find($this->department_id);
                $record = FmsLedgerAccount::where('department_id', $this->department_id)->first();
            }

            if ($record) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! Duplicate data!',
                    'text' => 'the selected unit has an account!',
                ]);
                return false;
            }

            $opening_balance = (float) str_replace(',', '', $this->opening_balance);
            $rate = (float) str_replace(',', '', $this->rate);

            $account = new FmsLedgerAccount();
            $account->name = $this->name;
            $account->is_active = $this->is_active;
            $account->account_number = $this->account_number;
            $account->department_id = $this->department_id;
            $account->currency_id = $this->currency_id;
            $account->project_id = $this->project_id;
            // $account->account_type = $this->account_type;
            $account->opening_balance = $opening_balance;
            $account->current_balance = $opening_balance;
            $account->as_of = $this->as_of;
            $account->is_active = $this->is_active;
            $account->description = $this->description;
            $account->requestable()->associate($requestable);
            $account->save();

            if($opening_balance){
            $incomeTrans = new FmsTransaction();
            $incomeTrans->trx_no = 'TRL' . GeneratorService::getNumber(7);
            $incomeTrans->trx_ref = $account->account_number ?? 'TRF' . GeneratorService::getNumber(7);;
            $incomeTrans->trx_date = date('Y-m-d');
            $incomeTrans->total_amount = $account->current_balance;
            $incomeTrans->account_amount = $account->current_balance;
            $incomeTrans->account_balance = $account->current_balance;
            $incomeTrans->ledger_account = $account->id;
            $incomeTrans->rate = $rate;
            $incomeTrans->department_id = $account->department_id;
            $incomeTrans->project_id = $account->project_id;
            $incomeTrans->currency_id = $account->currency_id;
            $incomeTrans->trx_type = 'Income';
            $incomeTrans->status = 'Approved';
            $incomeTrans->description = 'Unit initial Income deposit';
            $incomeTrans->entry_type = 'Internal';
            if ($account->to_project_id != null) {
                $incomeTrans->is_department = false;
            }
            $incomeTrans->requestable_type = $account->requestable_type;
            $incomeTrans->requestable_id = $account->requestable_id;
            $incomeTrans->save();
        }

        });
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'account created successfully!']);
    }

    public function updateAccount()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_ledger_accounts,name,' . $this->edit_id . '',
            'is_active' => 'required|numeric',
            'account_number' => 'required|unique:fms_ledger_accounts,account_number,' . $this->edit_id . '',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            // 'account_type' => 'required|integer',
            'opening_balance' => 'required',
            'current_balance' => 'required',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        $opening_balance = (float) str_replace(',', '', $this->opening_balance);
        $current_balance = (float) str_replace(',', '', $this->current_balance);

        $account = FmsLedgerAccount::where('id', $this->edit_id)->first();
        $account->name = $this->name;
        $account->is_active = $this->is_active;
        $account->account_number = $this->account_number;
        // $account->opening_balance = $opening_balance;
        // $account->current_balance = $current_balance;
        // $account->account_type = $this->account_type;
        // $this->account_type = $account->account_type;
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
        $this->currency_id = $account->currency_id;
        $this->opening_balance = $account->opening_balance;
        $this->current_balance = $account->current_balance;
        $this->as_of = $account->as_of;
        $this->is_active = $account->is_active;
        $this->description = $account->description;
        $this->createNew = true;
        $this->toggleForm = true;
        if ($this->project_id != null) {
            $this->entry_type == 'Project';
        } elseif ($this->department_id != null) {
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
        $accountSubType = FmsLedgerAccount::search($this->search)->with(['project', 'department', 'currency'])
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
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['projects'] = Project::get();
        $data['years'] = FmsFinancialYear::all();
        $data['types'] = FmsChartOfAccountsType::get();
        $data['accounts'] = $this->filterAccount()->where('is_active', 1)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.ledger.fms-ledger-accounts-component', $data);
    }
}
