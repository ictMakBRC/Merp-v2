<?php

namespace App\Http\Livewire\Finance\Requests;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Requests\FmsPaymentRequestPosition;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;

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
    public $ledger_account;
    public $is_department;
    public $invoiceData;
    public $toAccountData;
    public $fromAccountData;
    public $budgetLines;
    public $fiscal_year;
    public $description;
    public $ledgers;
    public $type;
    public $max = 0;
    public $unit_type = 'department';
    public $unit_id = 0;
    public $requestable_type;
    public $requestable_id;
    public $requestable;
    public function mount($type)
    {
        $this->budgetLines = collect([]);
        $this->ledgers = collect([]);
        $fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
        $this->fiscal_year = $fiscal_year->id??null;

        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->requestable = $requestable = Project::find($this->unit_id);
                $this->project_id = $requestable->id??null;
                $this->entry_type = 'Project';
                $this->updatedProjectId();
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->entry_type = 'Department';
                $this->requestable = $requestable = Department::find($this->unit_id);
                $this->department_id = $requestable->id??null;
                $this->updatedDepartmentId();
            }
            if ($requestable) {
                $this->requestable_type = get_class($requestable);
                $this->requestable_id = $this->unit_id;
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

    public function updatedRequestType()
    {
        $this->max = 0;
        if($this->request_type =='Petty Cash'){
            $this->max = 200000;
        }elseif($this->request_type =='Cash Imprest'){
            $this->max = 5000000;
        }else{
            $this->max = 1000000000;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'type' => 'required',
            'total_amount' => 'required',
            'request_description' => 'required|string',
            'amount_in_words' => 'required|string',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'department_id' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'nullable|integer',
            'ledger_account' => 'required|integer',
            'description' => 'required|string',
            'notice_text' => 'required|string',
        ]);
    }
    public $budgetLineBalance = 0, $budgetLineAmtHeld = 0, $budgetLineCur, $curCode;
    public $ledgerBalance = 0, $ledgerCur, $baseAmount = 0;
    public function updatedBudgetLineId()
    {
        $this->budgetLineCur = 0;
        $this->budgetLineBalance = 0;
        $data = FmsBudgetLine::where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
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
        $data = FmsLedgerAccount::where('id', $this->ledger_account)->with('currency')->first();
        $this->ledgerAmtHeld = $data->amount_held;
        $this->ledgerBalance = $data->current_balance - $this->ledgerAmtHeld;
        $this->ledgerCur = $data->currency->code ?? '';
        // dd($this->ledgerAmtHeld);
    }
    public $budgetExpense = 0;
    public $ledgerExpense = 0;
    public $ledgerNewBal = 0;
    public $budgetNewBal = 0;
    public $viewSummary = false;
    public function generateTransaction()
    {
        try {
            $this->ledgerExpense = exchangeCurrency($this->ledgerCur, 'foreign', $this->baseAmount);
            $this->budgetExpense = exchangeCurrency($this->budgetLineCur, 'foreign', $this->baseAmount);

            $this->ledgerNewBal = $this->ledgerBalance - $this->ledgerExpense;
            $this->budgetNewBal = $this->budgetLineBalance - $this->budgetExpense;
            $this->viewSummary = true;
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Generation failed!' . $e->getMessage()]);
        }
    }


    public function storeTransaction()
    {
        $this->validate([
            'request_type' => 'required',
            'total_amount' => 'required',
            'request_description' => 'required|string',
            'amount_in_words' => 'required|string',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'required|integer',
            'ledger_account' => 'required|integer',
            'notice_text' => 'required|string',
        ]);
       
     
     
        $requestable= null;
        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $this->department_id = null;
            $requestable  = Project::find($this->project_id);
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            $this->project_id = null;
            $requestable  = Department::find($this->department_id);
        }

        if($this->budgetNewBal<0){

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Low Line balance!',
                'text' => 'You don not have enough money on your budget line, your expense is '.$this->budgetExpense.' but your available balance is '.$this->budgetLineBalance,
            ]);
            return false;

        }
        if($this->request_type =='Petty Cash'){
            $this->max = 200000;
        }elseif($this->request_type =='Cash Imprest'){
            $this->max = 5000000;
        }else{
            $this->max = 1000000000;
        }
        if($this->max <  $this->baseAmount){
            
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Maximum amount exceeded!',
                'text' => 'You have gone beyond the maximum amount available for this request, your amount is '.$this->baseAmount.' but the maximum is '.$this->max,
            ]);
            return false;
        }
        try {
            DB::transaction(function () use($requestable) {
                $total_amount = (float) str_replace(',', '', $this->total_amount);
                $p_request = new FmsPaymentRequest();
                $p_request->request_code = 'PRE' . GeneratorService::getNumber(7);
                $p_request->request_description = $this->request_description;
                $p_request->request_type = $this->request_type;
                $p_request->total_amount = $total_amount;
                $p_request->ledger_amount = $this->ledgerExpense;
                $p_request->budget_amount = $this->budgetExpense;
                $p_request->amount_in_words = $this->amount_in_words;
                $p_request->rate = $this->rate;
                $p_request->currency_id = $this->currency_id;
                $p_request->notice_text = $this->notice_text;
                $p_request->department_id = $this->department_id;
                $p_request->project_id = $this->project_id;
                $p_request->budget_line_id = $this->budget_line_id;
                $p_request->ledger_account = $this->ledger_account;
                $p_request->requestable()->associate($requestable);
                $p_request->save();
                // dd($p_request);
                // if($p_request){
                $dataBudget = FmsBudgetLine::where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
                if ($dataBudget) {
                    $budgetAmountHeld = $dataBudget->amount_held;
                    $newBudgetAmountHeld = $budgetAmountHeld + $this->budgetExpense;
                    $dataBudget->amount_held = $newBudgetAmountHeld;
                    // $dataBudget->update();
                }

                $dataLeger = FmsLedgerAccount::where('id', $this->ledger_account)->with('currency')->first();              

                if ($dataLeger) {
                    $currentAmountHeld = $dataLeger->amount_held;
                    $newAmountHeld = $currentAmountHeld + $this->ledgerExpense;
                    $dataLeger->amount_held = $newAmountHeld;
                    // $dataLeger->update();
                }

                if ($p_request->requestable_type == 'App\Models\HumanResource\Settings\Department') {
                    $signatory = User::where('is_active', 1)->where('employee_id', $p_request->requestable?->supervisor)->first();
                } elseif ($p_request->requestable_type == 'App\Models\Grants\Project\Project') {                
                    $signatory = User::where('is_active', 1)->with('employee')->where('employee_id', $p_request->requestable?->pi)->first();
                }

                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request created successfully, please proceed!']);
                return redirect()->SignedRoute('finance-request_detail', $p_request->request_code);
            });
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transaction failed!' . $e->getMessage()]);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }

    }
    public function addSignatory($id)
    {
        $this->validate([
            'position' => 'required',
            'signatory_level' => 'required|integer',
            'approver_id' => 'required|integer',
        ]);
        $exists = FmsPaymentRequestAuthorization::where(['position' => $this->position, 'request_id' => $id])->first();
        // dd($exists);
        if ($exists) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Signatory already exists on this particular document, please select another different person']);
            return false;
        }
        $requestAuth = new FmsPaymentRequestAuthorization();
        $requestAuth->request_id = $id;
        $requestAuth->request_code = $this->requestCode;
        $requestAuth->position = 1;
        $requestAuth->level = 1;
        $requestAuth->approver_id = $this->approver_id;
        $requestAuth->save();
        if ($this->requestData->request_type != 'Petty Cash') {
            $positions = FmsPaymentRequestPosition::where('name_lock', '!=', 'head')
                ->when($this->requestable_type == 'App\Models\HumanResource\Settings\Department', function ($query) {
                    $query->where('name_lock', '!=', 'grants');})
                ->when($this->requestData->request_type == 'Internal Transfer', function ($query) {
                    $query->where('name_lock', '!=', 'operations');})->get();
            foreach ($positions as $position) {
                $exists = FmsPaymentRequestAuthorization::where(['position' => $position->id, 'request_id' => $id])->first();
                if (!$exists) {
                    $requestAuth = new FmsPaymentRequestAuthorization();
                    $requestAuth->request_id = $id;
                    $requestAuth->request_code = $this->requestCode;
                    $requestAuth->position = $position->id;
                    $requestAuth->level = $position->level;
                    $requestAuth->approver_id = $position->assigned_to;
                    $requestAuth->save();
                }
            }
        }
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment added successfully!']);
    }

    public function updatedFiscalYear()
    {
        $this->updatedProjectId();
        $this->updatedDepartmentId();
    }

    public function updatedRate()
    {
        $this->updatedTotalAmount();
        $this->viewSummary = false;
    }
    public function updatedTotalAmount()
    {
        $this->baseAmount = $this->rate * $this->total_amount;        
        $this->viewSummary = false;
        // if($this->total_amount!=''){
        //     $this->amount_in_words = convertToWords($this->total_amount, 'USD');
        // }
    }
   
    public function updatedProjectId()
    {
        $this->budgetLines = FmsBudgetLine::with('budget')->where('type', 'Expense')->WhereHas('budget', function ($query) {
            $query->where(['project_id' => $this->project_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
        })->get();
        $this->ledgers = FmsLedgerAccount::where('project_id', $this->project_id)->with(['project', 'department', 'currency'])->get();

    }
    public function updatedCurrencyId()
    {
        if ($this->currency_id) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
                $this->viewSummary = false;
            }
        }
    }

    public function updatedDepartmentId()
    {
        $this->budgetLines = FmsBudgetLine::with('budget')->where('type', 'Expense')->WhereHas('budget', function ($query) {
            $query->where(['department_id' => $this->department_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
        })->get();
        $this->ledgers = FmsLedgerAccount::where('department_id', $this->department_id)->with(['project', 'department', 'currency'])->get();
        $this->viewSummary = false;
    }

    public function updatedToAccount()
    {
        $this->toAccountData = FmsLedgerAccount::where('id', $this->to_account)->with(['project', 'department', 'currency'])->first();
        $this->viewSummary = false;
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
            // 'department_id',
            // 'project_id',
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
        $services = FmsPaymentRequest::search($this->search)->when($this->requestable_id && $this->requestable_type, function ($query) {
            $query->where(['requestable_id'=> $this->requestable_id,'requestable_type' => $this->requestable_type]);})
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
        return view('livewire.finance.requests.fms-payment-requests-component', $data);
    }
}
