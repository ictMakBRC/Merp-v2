<?php

namespace App\Http\Livewire\Finance\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Finance\Accounting\FmsLedgerAccount;

class FmsPaymentRequestsComponent extends Component
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
    public $request_description;
    public $request_type;
    public $total_amount;
    public $amount_in_words;
    public $requester_signature;
    public $date_submitted; 
    public $date_approved; 
    public $rate;           
    public $currency_id;
    public $notice_text;
    public $department_id;
    public $project_id;
    public $budget_line_id;
    public $status;
    public $created_by;   
    public $updated_by;             
    public $request_table;
    public $subject_id;
    public $entry_type = 'Department';
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
            'total_amount' => 'required',
            'request_description' => 'required|string',
            'amount_in_words' => 'required|string',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'billed_department' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'nullable|integer',
            'from_account' => 'required|integer',
            'description' => 'required|string',
            'notice_text' => 'required|string',
        ]);
    }

    public function storeTransaction()
    {
        $this->validate([
            'total_amount' => 'required',
            'request_description' => 'required|string',
            'amount_in_words' => 'required|string',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'billed_department' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'nullable|integer',
            'from_account' => 'required|integer',
            'description' => 'required|string',
            'notice_text' => 'required|string',
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

        try{
        DB::transaction(function () {
            $total_amount = (float) str_replace(',', '', $this->total_amount);

            $trans = new FmsPaymentRequest();
            $trans->trx_no = 'TRE' . GeneratorService::getNumber(7);
            $trans->trx_date = $this->as_of ?? date('Y-m-d');
            $trans->total_amount = $total_amount;
            $trans->from_account = $this->from_account;
            $trans->rate = $this->rate;
            $trans->department_id = $this->department_id;
            $trans->project_id = $this->project_id;
            $trans->budget_line_id = $this->budget_line_id;
            $trans->currency_id = $this->currency_id;
            $trans->trx_type = 'Expense';
            $trans->status = 'Approved';
            $trans->entry_type = 'Internal';
            if ($this->project_id != null) {
                $trans->is_department = false;
            }
            $trans->save();
            // FmsLedgerAccount::where('id', $this->from_account)->update(['current_balance' => DB::raw('current_balance - '.$this->ledgerExpense)]);
           
            $ledgerAccount = FmsLedgerAccount::find($this->from_account);
            $ledgerAccount->current_balance -= $this->ledgerExpense;
            $ledgerAccount->save();

            // FmsBudgetLine::where('id', $this->budget_line_id)->update(['primary_balance' => DB::raw('primary_balance - '.$this->budgetExpense)]);

            $budget = FmsBudgetLine::find($this->budget_line_id);
            $budget->primary_balance -= $this->budgetExpense;
            $budget->save();

            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction created successfully!']);
        });
    } catch (\Exception $e) {
        // If the transaction fails, we handle the error and provide feedback
        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transfer failed!'. $e->getMessage()]);
    }
    }

    public function updatedFiscalYear()
    {
        $this->updatedProjectId();
        $this->updatedDepartmentId();
    }
    public $budgetLineBalance=0, $budgetLineCur, $curCode;
    public $ledgerBalance=0, $ledgerCur, $baseAmount=0;
    public function updatedBudgetLineId()
    {
        $this->budgetLineCur = 0;
        $this->budgetLineBalance = 0;
        $data = FmsBudgetLine::Where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
        $this->budgetLineBalance = $data->primary_balance ?? 0 - $data->amount_held ?? 0;
        $this->budgetLineCur = $data->budget?->currency?->code ?? '';
        $this->currency_id = $data->budget?->currency_id ?? '';
        $this->updatedCurrencyId();
    }

    public function updatedFromAccount()
    {
        $this->ledgerCur = 0;
        $this->ledgerBalance = 0;
        $data = FmsLedgerAccount::Where('id', $this->from_account)->with('currency')->first();
        $this->ledgerBalance = $data->current_balance ?? 0 - $data->amount_held ?? 0;
        $this->ledgerCur = $data->currency->code ?? '';
    }

    public function updatedRate()
    {
        $this->updatedTotalAmount();
    }
    public function updatedTotalAmount()
    {
        $this->baseAmount = $this->rate * $this->total_amount;
    }
    public $budgetExpense = 0;
    public $ledgerExpense = 0;
    public $ledgerNewBal = 0;
    public $budgetNewBal = 0;
    public $viewSummary = false;
    public function generateTransaction()
    {
        try{
        $this->ledgerExpense = exchangeCurrency($this->ledgerCur, 'foreign', $this->baseAmount);
        $this->budgetExpense = exchangeCurrency($this->budgetLineCur, 'foreign', $this->baseAmount);

        $this->ledgerNewBal = $this->ledgerBalance - $this->ledgerExpense;
        $this->budgetNewBal = $this->budgetLineBalance - $this->budgetExpense;
        $this->viewSummary = true;
    } catch (\Exception $e) {
        // If the transaction fails, we handle the error and provide feedback
        $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Generation failed!'. $e->getMessage()]);
    }
    }

    public function updatedProjectId()
    {
        $this->budgetLines = FmsBudgetLine::with('budget')->WhereHas('budget', function ($query) {
            $query->where(['project_id' => $this->project_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
        })->get();
        $this->ledgers = FmsLedgerAccount::Where('project_id', $this->project_id)->with(['project', 'department', 'currency'])->get();

    }
    public function updatedCurrencyId()
    {
        if($this->currency_id){
        $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

        if ($latestRate) {
            $this->rate = $latestRate->exchange_rate;
        }
    }
    }

    public function updatedDepartmentId()
    {
        $this->budgetLines = FmsBudgetLine::with('budget')->WhereHas('budget', function ($query) {
            $query->where(['department_id' => $this->department_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
        })->get();
        $this->ledgers = FmsLedgerAccount::where('department_id', $this->department_id)->with(['project', 'department', 'currency'])->get();
    }

    public function updatedToAccount()
    {
        $this->toAccountData = FmsLedgerAccount::where('id', $this->to_account)->with(['project', 'department', 'currency'])->first();
    }

    public function editData(FmsPaymentRequest $service)
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
            'request_description',
            'request_type',
            'total_amount',
            'amount_in_words',
            'requester_signature',
            'date_submitted', 
            'date_approved', 
            'rate',           
            'currency_id',
            'notice_text',
            'department_id',
            'project_id',
            'budget_line_id',
            'status', 
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
        $services = FmsPaymentRequest::search($this->search)
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
        $data['requests'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        
        $data['currencies'] = FmsCurrency::where(['is_active'=> 1,'id'=>$this->currency_id])->get();
        return view('livewire.finance.requests.fms-payment-requests-component', $data);
    }
}
