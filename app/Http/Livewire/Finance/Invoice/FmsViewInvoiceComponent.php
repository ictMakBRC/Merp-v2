<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Invoice\FmsInvoiceItem;
use App\Models\Finance\Invoice\FmsInvoicePayment;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;

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
    public $rate=1;
    public $department_id;
    public $project_id;
    public $billed_department;
    public $billed_project;
    public $customer_id;
    public $currency_id;
    public $budget_line_id;
    public $account_id;
    public $trx_type;
    public $entry_type;
    public $is_active;
    public $is_department;
    public $invoiceData;
    public $to_account;
    public $ledgerCur;
    public $ledgerBalance=0;
    public $ledgerIncome=0;
    public $baseAmount=0;

    public function mount($inv_no)
    {
        $this->invoiceCode = $inv_no;

    }
    public function updatedToAccount()
    {
        $this->ledgerCur = 0;
        $this->ledgerBalance = 0;
        $data = FmsLedgerAccount::Where('id', $this->to_account)->with('currency')->first();
        $this->ledgerBalance = $data->current_balance ?? 0 - $data->amount_held ?? 0;
        $this->ledgerCur = $data->currency->code ?? '';
    }
    public function updatedPaymentAmount()
    {
        if($this->payment_amount !='' && $this->rate){            
            $this->baseAmount = $this->rate * $this->payment_amount;
        }else{
            $this->baseAmount =0;
        }
    }
    public function savePayment($id)
    {
        $this->validate([
            'as_of' => 'required',
            'payment_amount' => 'required',
            'status' => 'required',
            'description' => 'required',
            'to_account' => 'required',
        ]);
        DB::transaction(function () use ($id) {
        $payement = new FmsInvoicePayment();
        $payement->payment_reference = $this->payment_reference ?? 'P' . GeneratorService::getNumber(7);
        $payement->as_of = $this->as_of;
        $payement->payment_amount = $this->payment_amount;
        $payement->payment_balance = $this->payment_balance;
        $payement->invoice_id = $id;
        $payement->status = $this->status;
        $payement->save();
        $this->trx_ref = $payement->payment_reference;
        FmsInvoice::where(['id' => $this->payment_amount])
            ->increment('total_paid', 1);
        // Find the specific record you want to update
        $invoice = FmsInvoice::find($id);
        if ($invoice) {
            // Calculate the new total_paid amount (e.g., increment by a certain value)
            $newTotalPaid = $invoice->total_paid + $this->payment_amount;

            // Update the invoice status based on the new total_paid amount
            $status = ($newTotalPaid >= $invoice->total_amount) ? 'Paid' : 'Partially Paid';

            // Use a database transaction for data consistency
            DB::transaction(function () use ($invoice, $newTotalPaid, $status) {
                // Update the total_paid column
                $invoice->update(['total_paid' => $newTotalPaid]);
                // Update the status column
                $invoice->update(['status' => $status]);

                $trans = new FmsTransaction();
                $trans->trx_no = 'TRX' . GeneratorService::getNumber(7);
                $trans->trx_ref = $this->trx_ref;
                $trans->trx_date = $this->as_of;
                $trans->total_amount = $this->payment_amount;
                $trans->rate = $this->rate;
                $trans->to_account = $this->to_account;
                $trans->department_id =  $this->invoiceData->department_id;
                $trans->project_id = $this->invoiceData->project_id;
                $trans->billed_department = $this->invoiceData->billed_department;
                $trans->billed_project = $this->invoiceData->billed_project;
                $trans->customer_id = $this->invoiceData->customer_id;
                $trans->currency_id = $this->invoiceData->currency_id;
                $trans->trx_type = 'Income';
                $trans->entry_type = 'Invoice';
                if($this->invoiceData->project_id != null){                    
                    $trans->is_department = false;
                }
                $trans->save();
                $this->ledgerIncome = exchangeCurrency($this->ledgerCur, 'foreign', $this->baseAmount);
                $ledgerAccount = FmsLedgerAccount::find($this->to_account);
                $ledgerAccount->current_balance += $this->ledgerIncome;
                $ledgerAccount->save();

            });
        }

        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget-line item created successfully!']);
    });
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
        ]);
    }
    public function approveInvoice($id)
    {
        FmsInvoice::where(['invoice_no' => $this->invoiceCode, 'id' => $id])->update(['status' => 'Approved']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice approved successfully!']);
    }
    public function render()
    {
        $data['invoice_data'] = $invoiceData = FmsInvoice::where('invoice_no', $this->invoiceCode)->with(['department', 'project', 'customer', 'biller', 'currency', 'payments'])->first();
        if ($invoiceData) {
            $this->invoiceData = $invoiceData;
            $this->currency = $invoiceData->currency->code ?? 'UG';
            $this->amount = $invoiceData->total_amount ?? '0';
            $this->balance = $invoiceData->total_paid ?? '0';
            $this->payment_balance = $this->amount - $this->balance;
            $this->currency_id = $invoiceData->currency_id;
            // $this->payment_amount = $this->amount - $this->balance;
            $latestRate = FmsCurrencyUpdate::where('currency_id', $invoiceData->currency_id)->latest()->first();

                if ($latestRate) {
                    $this->rate = $latestRate->exchange_rate;
                }

            $data['ledgers'] = FmsLedgerAccount::where('department_id', $invoiceData->department_id)->get();
            $data['items'] = FmsInvoiceItem::where('invoice_id', $data['invoice_data']->id)->with(['service'])->get();
        } else {
            $data['items'] = collect([]);
            $data['ledgers'] = collect([]);
        }
        return view('livewire.finance.invoice.fms-view-invoice-component', $data);
    }
}
