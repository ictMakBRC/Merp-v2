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
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Budget\FmsBudgetAdjustment;
use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Requests\FmsPaymentRequestPosition;

class FmsViewBudgetComponent extends Component
{
    public $budgetData;
    public $budgetCode;
    public $status;
    public $comment;
    public $max_amount = 0;
    public $amount;
    public $reason;
    public $description;
    public $from_budget_line_id;
    public $to_budget_line_id;

    public $requestable_type;
    public $requestable_id;
    public $requestable;
    public $unit_id;
    public function mount($budget)
    {
        $this->budgetCode = $budget;
        $this->budgetData = $budgetData= FmsBudget::where('code', $this->budgetCode)->with('requestable')->first();
        if (auth()->user()->hasPermission(['approve_unit_budget'])) {            
            $this->requestable = $budgetData->requestable??null;
            $this->requestable_type = $budgetData->requestable_type??null;
            $this->requestable_id = $budgetData->requestable_id??null;
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->requestable = $requestable = Project::find($this->unit_id);
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->requestable = $requestable = Department::find($this->unit_id);
            }
            if ($requestable) {
                $this->requestable_type = get_class($requestable);
                $this->requestable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }
        if($this->requestable_id != $budgetData->requestable_id){
            abort(403, 'Unauthorized access or action.'); 
        }
    }
    public function submitBudget()
    {
        $data = FmsBudget::where('code', $this->budgetCode)->first();
        $data->status = 'Submitted';
        $data->update();
        $body = 'Hello, A unit has submitted a budget #' . $this->budgetCode . ' which needs to be approved, please login to view more details';
        $head = FmsPaymentRequestPosition::where('name_lock', 'finance')->first();
        $this->SendMail($head->assigned_to ?? '1', $body);
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Budget approval request has been successfully submitted! ']);
    }
    public function rejectBudget()
    {
        $this->validate([
            'status' => 'required',
            'comment' => 'nullable|string',
        ]);
        $data = FmsBudget::where('code', $this->budgetCode)->first();
        $data->status = $this->status ?? 'Approved';
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
    public function approveBudget()
    {
        DB::transaction(function () {
            $this->validate([
                'status' => 'required',
                'comment' => 'nullable|string',
            ]);
            $budgetData = FmsBudget::where('code', $this->budgetCode)->first();
            if ($budgetData) {
                if($this->status=='Approved'){
                    $totalExpense = FmsBudgetLine::where(['fms_budget_id' => $budgetData->id, 'type' => 'Expense'])->sum('allocated_amount');
                    $totalIncome = FmsBudgetLine::where(['fms_budget_id' => $budgetData->id, 'type' => 'Revenue'])->sum('allocated_amount');
                    $budgetData->estimated_expenditure = $totalExpense;
                    $budgetData->estimated_income = $totalIncome;
                    $budgetData->estimated_income_local = $totalIncome*$budgetData->rate;
                    $budgetData->estimated_expense_local = $totalExpense*$budgetData->rate;
                }
                $budgetData->status = $this->status ?? 'Approved';
                $budgetData->comment = $this->comment;
                $budgetData->acknowledged_by = auth()->user()->id;
                $budgetData->acknowledged_at = date('Y-m-d');
                $budgetData->update();
                $this->dispatchBrowserEvent('close-modal');
                $body = 'Hello, Your budget #' . $this->budgetCode . ' has been approved, please login to view more details';
                $this->SendMail($budgetData->created_by, $body);
                $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Request has been successfully Approved! ']);
            
            }
        });
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
    public function updatedFromLine()
    {
        $data = FmsBudgetLine::where('id', $this->from_line)->first();
        $this->max_amount = $data->primary_balance ?? 0;
    }
    public function makeTransfer()
    {
        $this->validate([
            'from_line' => 'required|numeric',
            'to_line' => 'required|numeric',
            'reason' => 'required|string',
            'description' => 'nullable|string',
            'transfer_amount' => 'required|numeric',
        ]);
        if ($this->from_line == $this->to_line) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! come on',
                'text' => 'BudgetLines should be different',
            ]);
            return false;
        }
        if ($this->transfer_amount > $this->max_amount) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! come on',
                'text' => 'That money is greater than what you have',
            ]);
            return false;
        }

        try {
            DB::transaction(function () {
                $requestData = FmsBudget::where('code', $this->budgetCode)->first();

                if ($requestData) {

                    $from_budget = FmsBudgetLine::find($this->from_line);
                    $from_budget->primary_balance -= $this->transfer_amount;
                    $from_budget->save();

                    $budget = FmsBudgetLine::find($this->to_line);
                    $budget->primary_balance += $this->transfer_amount;
                    $budget->save();

                    $ref = 'ADJ' . GeneratorService::getNumber(7);
                    $trans = new FmsBudgetAdjustment();
                    $trans->amount = $this->transfer_amount;
                    $trans->reason = $this->reason;
                    $trans->description = $this->description;
                    $trans->status = 'Approved';
                    $trans->from_budget_line_id = $this->from_line;
                    $trans->to_budget_line_id = $this->to_line;
                    $trans->save();

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
    public function close(){
        $this->resetInputs();
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
            'amount',
            'reason',
            'description',
            'status',
            'comment',
            'from_budget_line_id',
            'to_budget_line_id',
        ]);
    }
    public function render()
    {
        $data['budget_data'] = $this->budgetData;
        if ($this->budgetData) {
            $data['budget_lines'] = FmsBudgetLine::where('fms_budget_id', $data['budget_data']->id)->get();
        } else {
            $data['budget_lines'] = collect([]);
        }
        $chartOfAccts = FmsChartOfAccount::where('is_active', 1)->with(['type']);
        $data['incomes'] = $chartOfAccts->where('account_type', 4)->get();
        $data['expenses'] = FmsChartOfAccount::where('is_active', 1)->with(['type'])->where('account_type', 3)->get();
        return view('livewire.finance.budget.fms-view-budget-component', $data);
    }
}
