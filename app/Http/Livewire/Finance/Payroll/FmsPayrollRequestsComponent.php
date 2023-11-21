<?php

namespace App\Http\Livewire\Finance\Payroll;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Services\Finance\Requests\FmsPaymentRequestService;

class FmsPayrollRequestsComponent extends Component
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

    public $year;
    public $month;
    public $currency_id;
    public $rate;
    public $notice_text;
    public $department_id;
    public $project_id;
    public $budget_line_id;    
    public $baseAmount;
    public $budgetLines;
    public $ledgers;
    public $total_amount;
    public $fiscal_year;
    public $entry_type = 'Department';
    public $ledger_account;

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset([
            'total_amount',
            'rate',
            'currency_id',
            'department_id',
            'project_id',
            'budget_line_id',
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
        $this->month = now()->format('m');
        $this->year = now()->format('Y');
        $this->budgetLines = collect([]);
        $this->ledgers = collect([]);
        $fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
        $this->fiscal_year = $fiscal_year->id??null;
    }


    public function updatedFiscalYear()
    {
        $this->updatedProjectId();
        $this->updatedDepartmentId();
    }

    public function updatedRate()
    {
        $this->updatedTotalAmount();
    }
    public function updatedTotalAmount()
    {
        if (is_numeric($this->rate) || is_numeric($this->total_amount)) {
            // Handle the case where total_amount is null or not numeric            
            $this->baseAmount = $this->rate * $this->total_amount;
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
        if ($this->currency_id) {
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
    public $budgetLineBalance = 0, $budgetLineAmtHeld = 0, $budgetLineCur, $curCode;
    public $ledgerBalance = 0, $ledgerCur;
    public function updatedBudgetLineId()
    {
        $this->budgetLineCur = 0;
        $this->budgetLineBalance = 0;
        $data = FmsBudgetLine::Where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
        $this->budgetLineAmtHeld = $data->amount_held;
        $this->budgetLineBalance = $data->primary_balance - $this->budgetLineAmtHeld;
        $this->budgetLineCur = $data->budget?->currency?->code ?? '';
        $this->currency_id = $data->budget?->currency_id ?? '';
        $this->updatedCurrencyId();
        // dd($this->budgetLineBalance);
    }

    
    public $ledgerAmtHeld = 0;
    public function updatedLedgerAccount()
    {
        $this->ledgerCur = 0;
        $this->ledgerBalance = 0;
        $data = FmsLedgerAccount::Where('id', $this->ledger_account)->with('currency')->first();
        $this->ledgerAmtHeld = $data->amount_held;
        $this->ledgerBalance = $data->current_balance - $this->ledgerAmtHeld;
        $this->ledgerCur = $data->currency->code ?? '';
        // dd($this->ledgerAmtHeld);
    }
    public function storePaymentRequest(FmsPaymentRequestService $paymentRequestService)
    {

       
        $requestable = null;
        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $this->department_id = null;
            $requestable = Project::find($this->project_id);
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            $this->project_id = null;
            $requestable = Department::find($this->department_id);

        }

        $this->validate([
            'month' => 'required|integer',
            'year' => 'required|integer',
            'currency_id' => 'required|integer',
            'rate' => 'required|numeric',
            'ledger_account'=>'required|integer',
            'budget_line_id'=>'required|integer',
        ]);

        // $exists = FmsPaymentRequest::where('requestable_id', $requestable->id)->where('requestable_type', get_class($requestable))->first();
        // dd($exists);
        $record = FmsPaymentRequest::where(['month' => $this->month, 'year' => $this->year, 'currency_id' => $this->currency_id])
        ->where('requestable_id', $requestable->id)->where('requestable_type', get_class($requestable))->first();
        if ($record) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! payroll already exists!',
                'text' => 'Months already paid or in queue',
            ]);
            return redirect()->SignedRoute('finance-payroll_unit_details', $record->request_code);
            return false;

        }
        try{
        $requestData = [
            'request_type' => 'Salary',
            'request_description' => 'Salary Payment For '.$this->month.'-'.$this->year,
            'ledger_account'=>$this->ledger_account,
            'month'=>$this->month,
            'year'=>$this->year,
            'rate'=>$this->rate,
            'project_id'=>$this->project_id,
            'department_id'=>$this->department_id,
            'currency_id'=>$this->currency_id,
            'ledger_account'=>$this->ledger_account,
            'budget_line_id'=>$this->budget_line_id,
            'requestable'=>$requestable,
        ];

        // Call the service to create the payment request
        $saveData = $paymentRequestService->createPaymentRequest($requestData);  
        $this->reset();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll created successfully!']);      
        return redirect()->SignedRoute('finance-payroll_unit_details', $saveData->request_code);
        // dd($saveData);
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transaction failed!' . $e->getMessage()]);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }
        // Additional logic or response handling
        // finance-payroll_unit_details
        // Clear form fields after submission

    }

    public function mainQuery()
    {
        $services = FmsPaymentRequest::search($this->search)->where('request_type', 'Salary')
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

        $data['currencies'] = FmsCurrency::where(['is_active' => 1, 'id' => $this->currency_id])->get();

        return view('livewire.finance.payroll.fms-payroll-requests-component', $data);
    }
}
