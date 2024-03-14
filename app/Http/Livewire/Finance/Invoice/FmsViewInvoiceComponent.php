<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Invoice\FmsInvoiceItem;
use App\Models\Finance\Invoice\FmsInvoicePayment;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsPaymentRequestAttachment;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Services\GeneratorService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FmsViewInvoiceComponent extends Component
{
    public $invoiceCode;
    public $amount = 0;
    public $balance = 0;
    public $currency;
    public $invoice_id;
    public $payment_reference;
    public $as_of;
    public $payment_amount;
    public $payment_balance;
    public $description;
    public $created_by;
    public $updated_by;
    public $status;

    public $trx_no;
    public $trx_ref;
    public $trx_date;
    public $total_amount;
    public $rate = 1;
    public $department_id;
    public $project_id;
    public $billed_department;
    public $billed_project;
    public $customer_id;
    public $currency_id;
    public $budget_line_id;
    public $to_budget_line_id;
    public $account_id;
    public $trx_type;
    public $entry_type;
    public $is_active;
    public $is_department;
    public $invoiceData;
    public $to_account;
    public $ledger_account;
    public $ledgerCur;
    public $to_ledgerCur;
    public $ledgerBalance = 0;
    public $ledgerIncome = 0;
    public $baseAmount = 0;
    public $biller;
    public $billed;
    public $fiscal_year;
    public $notice_text;
    public $request_description;
    public $amount_in_words;
    public $toBudgetLines;

    public $invoice_type;
    public $billed_by;
    public $billed_to;
    public $approved_by;
    public $acknowledged_by;
    public $paid_by;
    public $approved_at;
    public $acknowledged_at;
    public $paid_at;
    public $services;

    public function mount($inv_no)
    {
        $this->invoiceCode = $inv_no;
        $this->budgetLines = collect([]);
        $this->toBudgetLines = collect([]);        
        $this->services= collect([]);
        $this->ledger = [];
        $fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
        $this->fiscal_year = $fiscal_year->id;

    }

    public function updatedPaymentAmount()
    {
        if ($this->payment_amount != '' && $this->rate) {
            $this->baseAmount = $this->rate * $this->payment_amount;
        } else {
            $this->baseAmount = 0;
        }
    }
    public function savePayment($id)
    {
        $this->validate([
            'as_of' => 'required',
            'payment_amount' => 'required',
            // 'status' => 'required',
            'description' => 'required',
            'to_account' => 'required',
            'to_budget_line_id' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($id) {
                $payement = new FmsInvoicePayment();
                $payement->payment_reference = $this->payment_reference ?? 'P' . GeneratorService::getNumber(7);
                $payement->as_of = $this->as_of;
                $payement->payment_amount = $this->payment_amount;
                $payement->payment_balance = $this->payment_balance;
                $payement->invoice_id = $id;
                $payement->description = $this->description;
                $payement->status = $this->status;
                $payement->save();
                $this->trx_ref = $payement->payment_reference;
                // FmsInvoice::where(['id' => $this->payment_amount])
                //     ->increment('total_paid', 1);
                // Find the specific record you want to update
                $invoice = FmsInvoice::find($id);
                // if ($invoice) {

                    // Calculate the new total_paid amount (e.g., increment by a certain value)
                    $newTotalPaid = $invoice->total_paid + $this->payment_amount;

                    // Update the invoice status based on the new total_paid amount
                    $status = ($newTotalPaid >= $invoice->total_amount) ? 'Fully Paid' : 'Partially Paid';

                    // DB::transaction(function () use ($invoice, $newTotalPaid, $status) {
                        // Update the total_paid column
                        $invoice->update(['total_paid' => $newTotalPaid]);
                        $invoice->update(['status' => $status]);
                        $invoice->update(['paid_by' => auth()->user()->id]);
                        $invoice->update(['paid_at' => Carbon::now()]);
                        $account_balance =0;
                        $lineIncome =0;
                        $line_balance = 0;
                        $this->ledgerIncome = exchangeCurrency($this->to_ledgerCur, 'foreign', $this->baseAmount);
                        if($this->to_account){
                            $ledgerAccount = FmsLedgerAccount::where('id', $this->to_account)->first();
                            // dd($this->ledgerCur);
                            $account_balance = $ledgerAccount->current_balance + $this->ledgerIncome;
                            $ledgerAccount->current_balance = $account_balance;
                            $ledgerAccount->save();
                        }
                        if($this->to_budget_line_id){
                            $lineAccount = FmsBudgetLine::where('id', $this->to_budget_line_id)->with('budget.currency')->first();
                            // dd($lineAccount);
                            $lineCur = $lineAccount->budget->currency->code;
                            $lineIncome = exchangeCurrency($lineCur, 'foreign', $this->baseAmount);
                            $line_balance = $lineAccount->primary_balance + $lineIncome;
                            $lineAccount->primary_balance = $line_balance;
                            $lineAccount->save(); 
                        }
                        $requestable = null;
                        if ($invoice->project_id) {
                            $requestable = Project::find($invoice->project_id);
                            // dd('project');
                        } elseif ($invoice->department_id) {
                            $requestable = Department::find($invoice->department_id);
                            // dd('dpertment');
                        }
                        $trans = new FmsTransaction();
                        $trans->trx_no = 'TRX' . GeneratorService::getNumber(7);
                        $trans->trx_ref = $this->trx_ref;
                        $trans->trx_date = $this->as_of;
                        $trans->total_amount = $this->payment_amount;
                        $trans->rate = $this->rate;                        
                        $trans->amount_local = $this->payment_amount*$this->rate;                        
                        $trans->line_balance = $line_balance; 
                        $trans->line_amount = $lineIncome ; 
                        $trans->account_amount = $this->ledgerIncome; 
                        $trans->account_balance = $account_balance; 
                        $trans->ledger_account = $this->to_account;
                        $trans->budget_line_id = $this->to_budget_line_id;
                        $trans->department_id = $this->invoiceData->department_id;
                        $trans->bank_id = $this->invoiceData->bank_id;
                        $trans->invoice_id = $this->invoiceData->id;
                        $trans->payment_id = $payement->id;
                        $trans->project_id = $this->invoiceData->project_id;
                        $trans->billed_department = $this->invoiceData->billed_department;
                        $trans->billed_project = $this->invoiceData->billed_project;
                        $trans->customer_id = $this->invoiceData->customer_id;
                        $trans->currency_id = $this->invoiceData->currency_id;
                        $trans->trx_type = 'Income';
                        $trans->description = 'Payment for invoice '.$invoice->invoice_no;
                        $trans->entry_type = 'Invoice';
                        if ($this->invoiceData->project_id != null) {
                            $trans->is_department = false;
                        }
                        $trans->requestable()->associate($requestable);

                        // dd($trans);
                        $trans->save();
                       

                    // });
                    $this->resetInputs();
                    $this->dispatchBrowserEvent('close-modal');
                // }

                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payment saved successfully!']);
            });
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! something went wrong!',
                'text' =>  'Transaction failed!' . $e->getMessage(),
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transaction failed!' . $e->getMessage()]);
        }
    }
    public function close()
    {
        $this->resetInputs();
    }
    public function resetInputs()
    {
        $this->reset([
            'invoice_id',
            'payment_reference',
            'as_of',
            'payment_amount',
            'payment_balance',
            'payment_reference',
            'description',
            'created_by',
            'updated_by',
            'status',
            'to_account',
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
            'account_id',
            'trx_type',
            'entry_type',
            'status',
            'description',
            'is_department',
            'baseAmount',
            'invoice_type',
            'billed_by',
            'billed_to',
            'approved_by',
            'acknowledged_by',
            'paid_by',
            'approved_at',
            'acknowledged_at',
            'paid_at',
        ]);
    }
    public function approveInvoice($id)
    {
        FmsInvoice::where(['invoice_no' => $this->invoiceCode, 'id' => $id])->update(['approved_by' => auth()->user()->id, 'status' => 'Approved', 'approved_at' => date('Y-m-d H:i:s')]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice approved successfully!']);
    }
    public function acknowledgeInvoice($id)
    {
        FmsInvoice::where(['invoice_no' => $this->invoiceCode, 'id' => $id])->update(['acknowledged_by' => auth()->user()->id, 'status' => 'Acknowledged', 'acknowledged_at' => date('Y-m-d H:i:s')]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice Acknowledged successfully!']);
    }
    public function reviewInvoice($id)
    {
        FmsInvoice::where(['invoice_no' => $this->invoiceCode, 'id' => $id])->update(['reviewed_by' => auth()->user()->id, 'status' => 'Reviewed', 'reviewed_at' => date('Y-m-d H:i:s')]);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice Reviewed successfully!']);
    }
    public $budgetLineBalance = 0, $budgetLineAmtHeld = 0, $budgetLineCur, $curCode;
    public $budgetExpense = 0;
    public $ledgerExpense = 0;
    public $ledgerNewBal = 0;
    public $budgetNewBal = 0;
    public $viewSummary = false;
    public $budgetLines, $ledger, $to_ledger;

    public function updatedBudgetLineId()
    {
        $this->budgetLineCur = 0;
        $this->budgetLineBalance = 0;
        $data = FmsBudgetLine::where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
        $this->budgetLineAmtHeld = $data->amount_held ?? 0;
        $this->budgetLineBalance = $data->primary_balance ?? 0 - $this->budgetLineAmtHeld;
        $this->budgetLineCur = $data->budget?->currency?->code ?? '';
        $this->viewSummary = false;
        // $this->currency_id = $data->budget?->currency_id ?? '';

        // $this->updatedCurrencyId();
        // dd($this->budgetLineBalance);
    }
    public function generateTransaction()
    {
        $this->validate([
            'budget_line_id' => 'required',
            'ledger_account' => 'required',
            'to_account' => 'required',
        ]);
        try {
            $this->ledgerExpense = exchangeCurrency($this->ledgerCur, 'foreign', $this->baseAmount);
            $this->budgetExpense = exchangeCurrency($this->budgetLineCur, 'foreign', $this->baseAmount);
            // dd($this->budgetExpense);
            $this->ledgerNewBal = $this->ledgerBalance - $this->ledgerExpense;
            $this->budgetNewBal = $this->budgetLineBalance - $this->budgetExpense;
            $this->viewSummary = true;
        } catch (\Exception $e) {
            // If the transaction fails, we handle the error and provide feedback
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Generation failed!' . $e->getMessage()]);
        }
    }
    public function storeRequest()
    {
        $this->validate([
            'amount' => 'required',
            'request_description' => 'required|string',
            'amount_in_words' => 'required|string',
            'rate' => 'required|numeric',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'required|integer',
            'to_budget_line_id' => 'required|integer',
            'ledger_account' => 'required|integer',
            'to_account' => 'required|integer',
            'notice_text' => 'required|string',
        ]);

        $requestable = null;
        if ($this->invoiceData->billed_project) {
            $requestable = Project::find($this->invoiceData->billed_project);
            // dd('project');
        } elseif ($this->invoiceData->billed_department) {
            $requestable = Department::find($this->invoiceData->billed_department);
            // dd('dpertment');
        }

        if ($this->budgetNewBal < 0) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Low Line balance!',
                'text' => 'You don not have enough money on your budget line, your expense is ' . $this->budgetExpense . ' but your available balance is ' . $this->budgetLineBalance,
            ]);
            return false;

        }
        if ($this->ledger_account == $this->to_account) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Be serious!',
                'text' => 'You can not transfer funds on the same account ',
            ]);
            return false;

        }

        try {
            DB::transaction(function () use ($requestable) {
                $p_request = new FmsPaymentRequest();
                $p_request->request_code = 'NTR' . GeneratorService::getNumber(7);
                $p_request->request_description = $this->request_description;
                $p_request->request_type = 'Internal Transfer';
                $p_request->total_amount = $this->amount;
                $p_request->ledger_amount = $this->ledgerExpense;
                $p_request->budget_amount = $this->budgetExpense;
                $p_request->amount_in_words = $this->amount_in_words;
                $p_request->rate = $this->rate;
                $p_request->currency_id = $this->currency_id;
                $p_request->notice_text = $this->notice_text;
                $p_request->department_id = $this->invoiceData->billed_department;
                $p_request->to_department_id = $this->invoiceData->department_id;
                $p_request->project_id = $this->invoiceData->billed_project;
                $p_request->to_project_id = $this->invoiceData->project_id;
                $p_request->budget_line_id = $this->budget_line_id;
                $p_request->to_budget_line_id = $this->to_budget_line_id;
                $p_request->ledger_account = $this->ledger_account;
                $p_request->to_account = $this->to_account;
                $p_request->invoice_id = $this->invoiceData->id;
                $p_request->requestable()->associate($requestable);
                $p_request->save();
                // dd($p_request);
                // if($p_request){
                $dataBudget = FmsBudgetLine::where('id', $this->budget_line_id)->with('budget', 'budget.currency')->first();
                if ($dataBudget) {
                    $budgetAmountHeld = $dataBudget->amount_held;
                    $newBudgetAmountHeld = $budgetAmountHeld + $this->budgetExpense;
                    $dataBudget->amount_held = $newBudgetAmountHeld;
                    $dataBudget->update();
                }

                $dataLeger = FmsLedgerAccount::where('id', $this->ledger_account)->with('currency')->first();

                if ($dataLeger) {
                    $currentAmountHeld = $dataLeger->amount_held;
                    $newAmountHeld = $currentAmountHeld + $this->ledgerExpense;
                    $dataLeger->amount_held = $newAmountHeld;
                    $dataLeger->update();
                }

                $requestItem = new FmsPaymentRequestAttachment();
                $requestItem->request_id = $p_request->id;
                $requestItem->request_code = $p_request->requestCode;
                $requestItem->name = 'Invoice';
                $requestItem->reference = $this->invoiceData->invoice_no;
                $requestItem->save();

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
                'text' => 'Failed to save due to this error ' . $e->getMessage(),
            ]);
        }
    }
    public function render()
    {
        $data['invoice_data'] = $invoiceData = FmsInvoice::where('invoice_no', $this->invoiceCode)->with(['department', 'project', 'customer', 'billedDepartment', 'billedProject', 'currency', 'payments'])->first();
        if ($invoiceData) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $invoiceData->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
            }

            if ($invoiceData->invoice_type == 'External') {
                $this->billed = $invoiceData->customer;
            } elseif ($invoiceData->invoice_type == 'Internal') {
                //Preparing the charged unit account and budget-line expense
                if ($invoiceData->billed_department) {
                    $this->budgetLines = FmsBudgetLine::with('budget')->where('type', 'Expense')->WhereHas('budget', function ($query) use ($invoiceData) {
                        $query->where(['department_id' => $invoiceData->billed_department, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
                    })->get();
                    $this->ledger = FmsLedgerAccount::where('department_id', $invoiceData->billed_department)->first();
                    // $this->budgetLineAmtHeld = $data->amount_held??0;
                    $this->ledgerBalance = $this->ledger->current_balance ?? 0 - $this->ledger->amount_held ?? 0;
                    $this->ledger_account = $this->ledger->id;
                    $this->billed = $invoiceData->billedDepartment;
                    $this->ledgerCur = $this->ledger->currency->code ?? '';
                    // dd($this->ledgerCur);
                } elseif ($invoiceData->billed_project) {
                    $this->budgetLines = FmsBudgetLine::with('budget')->where('type', 'Expense')->WhereHas('budget', function ($query) use ($invoiceData) {
                        $query->where(['project_id' => $invoiceData->billed_project, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
                    })->get();
                    $this->ledger = FmsLedgerAccount::where('project_id', $invoiceData->billed_project)->first();
                    $this->ledgerBalance = $this->ledger->current_balance ?? 0 - $this->ledger->amount_held ?? 0;
                    $this->ledger_account = $this->ledger->id;
                    $this->billed = $invoiceData->billedProject;
                    $this->ledgerCur = $this->ledger->currency->code ?? '';
                }

                $this->baseAmount = $invoiceData->total_amount * $this->rate;
                // dd($this->baseAmount);
            }

            //Preparing the billing unit account
            if ($invoiceData->department_id) {
                $this->toBudgetLines = FmsBudgetLine::with('budget')->where('type', 'Revenue')->WhereHas('budget', function ($query) use ($invoiceData) {
                    $query->where(['department_id' => $invoiceData->department_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
                })->get();
                $this->to_ledger = FmsLedgerAccount::where('department_id', $invoiceData->department_id)->first();
                $this->to_account = $this->to_ledger->id;
                $this->biller = $invoiceData->department;
                $this->to_ledgerCur = $this->to_ledger->currency->code ?? '';

            } elseif ($invoiceData->project_id) {

                $this->toBudgetLines = FmsBudgetLine::with('budget')->where('type', 'Revenue')->WhereHas('budget', function ($query) use ($invoiceData) {
                    $query->where(['project_id' => $invoiceData->project_id, 'fiscal_year' => $this->fiscal_year])->with(['project', 'department', 'currency', 'budgetLines']);
                })->get();
                $this->to_ledger = FmsLedgerAccount::where('project_id', $invoiceData->project_id)->first();
                $this->biller = $invoiceData->project;
                $this->to_account = $this->to_ledger->id;
                $this->to_ledgerCur = $this->to_ledger->currency->code ?? '';
            }

            $this->invoiceData = $invoiceData;
            $this->notice_text = $invoiceData->description;
            $this->request_description = 'Payment request for invoice #' . $invoiceData->invoice_no;
            $this->currency = $invoiceData->currency->code ?? 'UG';
            $this->amount = $invoiceData->total_amount ?? '0';
            $this->balance = $invoiceData->total_paid ?? '0';
            $this->payment_balance = $this->amount - $this->balance;
            $this->currency_id = $invoiceData->currency_id;
            // $this->payment_amount = $this->amount - $this->balance;

            $data['ledgers'] = FmsLedgerAccount::where('is_active', true)->get();
            $data['items'] = FmsInvoiceItem::where('invoice_id', $data['invoice_data']->id)->with(['uintService.service'])->get();
        } else {
            $data['items'] = collect([]);
            $data['ledgers'] = collect([]);
        }
        return view('livewire.finance.invoice.fms-view-invoice-component', $data);
    }
}
