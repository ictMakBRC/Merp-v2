<?php

namespace App\Http\Livewire\Finance\Budget;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Jobs\SendNotifications;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Services\WhatAppMessageService;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Requests\FmsPaymentRequestPosition;

class FmsViewBudgetComponent extends Component
{
    public $budgetData;
    public $budgetCode;
    public $status;
    public $comment;
    public $max_amount = 0;
    public function mount($budget)
    {
        $this->budgetCode = $budget;

    }
    public function submitBudget()
    {
        $data = FmsBudget::where('code', $this->budgetCode)->first();
        $data->status = 'Submitted';
        $data->update();
        $body = 'Hello, A unit has submitted a budget #' . $this->budgetCode . ' which needs to be approved, please login to view more details';
        $head =  FmsPaymentRequestPosition::where('name_lock', 'finance')->first();
        $this->SendMail($head->assigned_to??'1', $body);
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Budget approval request has been successfully submitted! ']);
    }
    public function approveBudget()
    {
        $this->validate([
            'status'=>'required',
            'comment'=>'nullable|string'
        ]);
        $data = FmsBudget::where('code', $this->budgetCode)->first();
        $data->status = $this->status??'Approved';
        $data->comment = $this->comment;
        $data->acknowledged_by = auth()->user()->id;
        $data->acknowledged_at = date('Y-m-d');
        $data->update();
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $body = 'Hello, Your budget #' . $this->budgetCode . ' has been approved, please login to view more details';
        $this->SendMail($data->created_by, $body);
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Request has been successfully Approved! ']);
    }

    public function SendMail($id, $body)
    {
        try {
            $user = User::where('id', $id)->first();
            $link = URL::signedRoute('finance-budget_view', $this->budgetCode);
            $notification = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'MERP payment Request',
                'greeting' => 'Dear ' . $user->title . ' ' . $user->name,
                'body' => $body,
                'thanks' => 'Thank you, incase of any question, please reply to support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => $link,
                'department_id' => $this->requestData->created_by,
                'user_id' => $this->requestData->created_by,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
            $mm = SendNotifications::dispatch($notification)->delay(Carbon::now()->addSeconds(20));
            //   dd($mms);
        } catch (Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Document has been successfully marked complete! ']);
    }
    public $from_line, $to_line, $transfer_amount;
    public function updatedFromLine(){
       $data = FmsBudgetLine::where('id', $this->from_line)->first();
       $this->max_amount = $data->primary_balance??0;
    }
    public function makeTransfer()
    {
        $this->validate([
            'from_line'=>'required|numeric',
            'to_line'=>'required|numeric',
            'transfer_amount'=>'required|numeric',
        ]);
        if($this->from_line == $this->to_line){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! come on',
                'text' => 'BudgetLines should be different',
            ]);
            return false;
        }
        if($this->transfer_amount > $this->max_amount){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! come on',
                'text' => 'That money is greater than what you have',
            ]);
            return false;
        }

        try {
            DB::transaction(function ()  {
                $requestData = FmsBudget::where('code', $this->budgetCode)->first();

                if ($requestData) {

                    // FmsBudgetLine::where('id', $this->budget_line_id)->update(['primary_balance' => DB::raw('primary_balance - '.$this->budgetExpense)]);

                    $from_budget = FmsBudgetLine::find($this->from_line);
                    $from_budget->primary_balance -= $this->transfer_amount;
                    $from_budget->save();

                    $ref = 'ADJ' . GeneratorService::getNumber(7);
                    $trans = new FmsTransaction();
                    $trans->trx_no = 'TRE' . GeneratorService::getNumber(7);
                    $trans->trx_ref = $ref;
                    $trans->trx_date = date('Y-m-d');
                    $trans->total_amount = $this->transfer_amount;                    
                    $trans->amount_local = $this->transfer_amount*$requestData->rate; 
                    $trans->line_balance = $from_budget->primary_balance;
                    $trans->line_amount = $this->transfer_amount;
                    // $trans->account_amount = $requestData->ledger_amount;
                    // $trans->account_balance = $ledgerAccount->current_balance;
                    // $trans->ledger_account = $requestData->ledger_account;
                    $trans->rate = $requestData->rate;
                    $trans->financial_year_id = $requestData->fiscal_year;
                    $trans->department_id = $requestData->department_id;
                    $trans->project_id = $requestData->project_id;
                    $trans->budget_line_id = $this->from_line;
                    $trans->currency_id = $requestData->currency_id;
                    $trans->trx_type = 'Expense';
                    $trans->status = 'Approved';
                    $trans->description = 'Budget line adjustment loss';
                    $trans->entry_type = 'Internal';
                    if ($requestData->project_id != null) {
                        $trans->is_department = false;
                    }
                    $trans->requestable_type = $requestData->requestable_type;
                    $trans->requestable_id = $requestData->requestable_id;
                    $trans->save();

                       
                        $budget = FmsBudgetLine::find($this->to_line);
                        $budget->primary_balance += $this->transfer_amount;
                        $budget->save();

                        $incomeTrans = new FmsTransaction();
                        $incomeTrans->trx_no = 'TRI' . GeneratorService::getNumber(7);
                        $incomeTrans->trx_ref = $ref;
                        $incomeTrans->trx_date = date('Y-m-d');
                        $incomeTrans->total_amount = $this->transfer_amount;
                        $trans->amount_local = $this->transfer_amount*$requestData->rate; 
                        $incomeTrans->line_balance = $budget->primary_balance;
                        $incomeTrans->line_amount = $this->transfer_amount;
                        // $incomeTrans->account_amount = $accountIncome;
                        // $incomeTrans->account_balance = $creditAccount->current_balance;
                        // $incomeTrans->ledger_account = $requestData->to_account;
                        $incomeTrans->rate = $requestData->rate;
                        $incomeTrans->financial_year_id = $requestData->fiscal_year;
                        $incomeTrans->department_id = $requestData->to_department_id;
                        $incomeTrans->project_id = $requestData->to_project_id;
                        $incomeTrans->budget_line_id = $this->to_line;
                        $incomeTrans->currency_id = $requestData->currency_id;
                        $incomeTrans->trx_type = 'Income';
                        $incomeTrans->status = 'Approved';
                        $incomeTrans->description = 'Budget line adjustment gain';
                        $incomeTrans->entry_type = 'Internal';
                        if ($requestData->to_project_id != null) {
                            $incomeTrans->is_department = false;
                        }
                        $incomeTrans->requestable_type = $requestData->requestable_type;
                        $incomeTrans->requestable_id = $requestData->requestable_id;
                        $incomeTrans->save();

                    
                        $this->resetInputs();
                    $this->dispatchBrowserEvent('close-modal');
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction created successfully!']);
                }});
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! NOT YOUR TURN',
                'text' => 'Transaction failed ' . $e->getMessage(),
            ]);
            // $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transfer failed!' . $e->getMessage()]);

        }
    }
    public function resetInputs()
    {
        $this->reset([
            'transfer_amount',
            'from_line',
            'to_line',
            'comment',
            'status',
            'max_amount',
        ]);
    }
    public function render()
    {
        $data['budget_data'] = $budgetData = FmsBudget::where('code', $this->budgetCode)->first();
        if ($budgetData) {
            $this->budgetData = $budgetData;
            $data['budget_lines'] = FmsBudgetLine::where('fms_budget_id', $data['budget_data']->id)->get();
        } else {
            $data['budget_lines'] = collect([]);
        }
        $chartOfAccts = FmsChartOfAccount::where('is_active', 1)->with(['type']);
        $data['incomes'] = $chartOfAccts->where('account_type', 4)->get();
        $data['expenses'] = FmsChartOfAccount::where('is_active', 1)->with(['type'])->where('account_type', 3)->get();
        return view('livewire.finance.budget.fms-view-budget-component',$data);
    }
}
