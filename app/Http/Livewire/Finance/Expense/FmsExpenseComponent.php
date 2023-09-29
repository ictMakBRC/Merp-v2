<?php

namespace App\Http\Livewire\Finance\Expense;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Transactions\FmsTransaction;

class FmsExpenseComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $serviceIds;

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

    public $is_active = 1;
    public $trx_no;
    public $trx_ref;
    public $trx_date;
    public $total_amount;
    public $rate;
    public $department_id;
    public $project_id;
    public $billed_department;
    public $billed_project;
    public $customer_id;
    public $currency_id;
    public $budget_line_id;
    public $income_budget_line_id;
    public $to_account;
    public $trx_type;
    public $entry_type;
    public $from_account;
    public $is_department;
    public $invoiceData;
    public $toAccountData;
    public $fromAccountData;
    public $budgetLines;
    public $fiscal_year;
    public $description;
    public $ledgers;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->budgetLines = collect([]);
        $this->ledgers = collect([]);
        $fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
        $this->fiscal_year = $fiscal_year->id;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'trx_date' => 'required|date',
            'total_amount' => 'required',
            'trx_ref' => 'required',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'billed_project' => 'nullable|integer',
            'billed_department' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'nullable|integer',
            'income_budget_line_id' => 'nullable|integer',
            'to_account' => 'required|integer',
            'from_account' => 'required|integer',
            'description' => 'required|string',
        ]);
    }

    public function storeTransaction()
    {
        $this->validate([
            'trx_date' => 'required|date',
            'total_amount' => 'required',
            'trx_ref' => 'required',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'billed_project' => 'nullable|integer',
            'billed_department' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'nullable|integer',
            'to_account' => 'required|integer',
            'from_account' => 'required|integer',
            'description' => 'required|string',
        ]);

        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $this->department_id = null;
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            $this->project_id = null;
        }
        if ($this->to_account == $this->from_account) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! invalid transaction!',
                'text' => 'Please select different accounts!',
            ]);
            return false;
        }

        $total_amount = (float) str_replace(',', '', $this->total_amount);

        $trans = new FmsTransaction();
        $trans->trx_no = 'TRE' . GeneratorService::getNumber(7);
        $trans->trx_ref = $this->trx_ref;
        $trans->trx_date = $this->as_of;
        $trans->total_amount = $total_amount;
        $trans->from_account = $this->from_account;
        $trans->rate = $this->rate;
        $trans->department_id = $this->department_id;
        $trans->project_id = $this->project_id;
        $trans->budget_line_id = $this->budget_line_id;
        $trans->currency_id = $this->currency_id;
        $trans->trx_type = 'Expense';
        $trans->entry_type = 'Internal';
        if ($this->project_id != null) {
            $trans->is_department = false;
        }
        $trans->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transfer created successfully!']);
    }
  
    public function updatedFiscalYear()
    {
            $this->updatedProjectId();
            $this->updatedDepartmentId();
    }
    public $ledgerBalance, $budgetLineBalance;
    public function updatedBudgetLineId()
    {
            $this->updatedProjectId();
            $this->updatedDepartmentId();
    }

    public function updatedFromAccount()
    {
       $data = FmsLedgerAccount::Where('id', $this->from_account)->first();
        $this->ledgerBalance = $data->current_balance??0 - $data->amount_held??0;
    }

    public function updatedProjectId()
    {
            $this->budgetLines = FmsBudgetLine::with('budget')->WhereHas('budget', function ($query) {
                $query->where(['project_id' => $this->project_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency','budgetLines']);
            })->get();   
            $this->ledgers = FmsLedgerAccount::Where('project_id', $this->project_id)->with(['project', 'department', 'currency'])->get();
            
    }

    public function updatedDepartmentId()
    {
        $this->budgetLines = FmsBudgetLine::with('budget')->WhereHas('budget', function ($query) {
            $query->where(['department_id' => $this->department_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency','budgetLines']);
        })->get();   
        $this->ledgers = FmsLedgerAccount::where('department_id', $this->department_id)->with(['project', 'department', 'currency'])->get();
    }

   
    public function updatedToAccount()
    {
        $this->toAccountData = FmsLedgerAccount::where('id', $this->to_account)->with(['project', 'department', 'currency'])->first();
    }

    public function editData(FmsTransaction $service)
    {
        $this->edit_id = $service->id;

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
        $this->reset([

            'trx_no',
            'trx_ref',
            'trx_date',
            'total_amount',
            'rate',
            'department_id',
            'project_id',
            'billed_department',
            'billed_project',
            'customer_id',
            'currency_id',
            'budget_line_id',
            'trx_type',
            'entry_type',
            'description',
            'is_department',
        ]);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->serviceIds) > 0) {
            // return (new servicesExport($this->serviceIds))->download('services_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No services selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $services = FmsTransaction::search($this->search)->where('trx_type', 'Expense')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->serviceIds = $services->pluck('id')->toArray();

        return $services;
    }

    public function render()
    {
        $data['expenses'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        $data['years'] = FmsFinancialYear::all();
        return view('livewire.finance.expense.fms-expense-component', $data);
    }
}
