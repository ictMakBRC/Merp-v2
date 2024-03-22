<?php

namespace App\Http\Livewire\Finance\Budget;

use App\Models\Finance\Accounting\FmsChartOfAccount;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Budget\FmsUnitBudgetLine;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FmsBudgetLinesComponent extends Component
{
    public $budgetData;
    public $budgetCode;
    public $name;
    public $type;
    public $fms_budget_id;
    public $chat_of_account;
    public $allocated_amount;
    public $primary_balance;
    public $quantity;
    public $description;
    public $amount_held;
    public $created_by;
    public $updated_by;
    public $is_active;
    public $line_id;
    public $budget_year;
    public $confirmingDelete = false;
    public $budgetToDelete;
    public $selected_id;
    public function mount($budget)
    {
        $this->budgetCode = $budget;
        $this->budgetData =  FmsBudget::where('code', $this->budgetCode)->first();

    }
    function updatedLineId(){
     $budgetLine =   FmsUnitBudgetLine::where('id', $this->line_id)->first();
    //  dd($budgetLine);
     if($budgetLine){
        $this->name = $budgetLine->name;
        $this->description = $budgetLine->description;
     }
    }
    public function selectLine($id, $type){
        $this->line_id = null;
        $this->type = $type;
        $this->selected_id = $id;
    }
    public function saveBudgetLine($id)
    {
        $this->validate([
            'name' => 'required',
            'line_id' => 'required',
            'quantity' => 'required',
            'allocated_amount' => 'required',
            'description' => 'required',
        ]);
        $line_id = $this->line_id;
        // $budgetName = $this->name[$id];
        $budgetAmount = $this->allocated_amount;
        $description = $this->description;
        $quantity = $this->quantity;
        if($this->type =='Revenue'){
            $primaryAmount = 0;
        }else{
            $primaryAmount = $this->allocated_amount;
        }
        $record = FmsBudgetLine::where(['fms_budget_id'=>$this->budgetData->id, 'line_id'=>$this->line_id])->first();
        if($record){

            if($this->budgetData->status !='Pending'||$this->budgetData->status !='Saved'){
            
                $record->name = $this->name;
                $record->line_id = $line_id;
                $record->quantity = $quantity;
                $record->type = $this->type;
                $record->fms_budget_id = $this->budgetData->id;
                $record->chat_of_account = $id;
                $record->allocated_amount = $budgetAmount;
                $record->primary_balance = $primaryAmount;
                $record->description = $description;
                $record->amount_held = 0;
                $record->update();
                $this->resetInputs();
                $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'the selected line already exists on this budget and was updated!',
            ]);
            return false;
        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'The selected line already exists on a submitted budget and was approved!',
            ]);
            return false;

            }
        }
       
        $budgetLine = new FmsBudgetLine();
        $budgetLine->name = $this->name;
        $budgetLine->line_id = $line_id;
        $budgetLine->quantity = $quantity;
        $budgetLine->type = $this->type;
        $budgetLine->fms_budget_id = $this->budgetData->id;
        $budgetLine->chat_of_account = $id;
        $budgetLine->allocated_amount = $budgetAmount;
        $budgetLine->primary_balance = $primaryAmount;
        $budgetLine->description = $description;
        $budgetLine->amount_held = 0;
        $budgetLine->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget-line item created successfully!']);
    }
    function close(){
        $this->resetInputs();
        $this->description = null;
        $this->dispatchBrowserEvent('close-modal');
    }
    public function resetInputs()
    {
        $this->reset([
            'name',
            'type',
            'fms_budget_id',
            'chat_of_account',
            'allocated_amount',
            'primary_balance',
            'description',
            'amount_held',
            'created_by',
            'updated_by',
            'quantity',
            'is_active',
            'line_id',
            'selected_id'
        ]);
        $this->dispatchBrowserEvent('close-modal');
        // return redirect(request()->header('Referer'));
    }
    public function confirmDelete($budgetId)
    {
        $this->confirmingDelete = true;
        $this->budgetToDelete = $budgetId;
    }

    public function saveBudget()
    {
        DB::transaction(function () {
            $budgetData = FmsBudget::where('code', $this->budgetCode)->first();
            if ($budgetData) {
                $totalExpense = FmsBudgetLine::where(['fms_budget_id' => $budgetData->id, 'type' => 'Expense'])->sum('allocated_amount');
                $totalIncome = FmsBudgetLine::where(['fms_budget_id' => $budgetData->id, 'type' => 'Revenue'])->sum('allocated_amount');
                $budgetData->estimated_expenditure = $totalExpense;
                $budgetData->estimated_income = $totalIncome;
                // $budgetData->estimated_income_local = $totalIncome*$budgetData->rate;
                // $budgetData->estimated_expense_local = $totalExpense*$budgetData->rate;
                $budgetData->status = 'Saved';
                $budgetData->update();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget saved successfully!']);
                return redirect()->signedRoute('finance-budget_view', $this->budgetCode);
            }
        });
    }

    public function deleteRecord()
    {

        if($this->budgetData->status =='Pending'||$this->budgetData->status =='Saved'){
            FmsBudgetLine::find($this->budgetToDelete)->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget-line item deleted successfully!']);
            $this->confirmingDelete = false;
            $this->budgetToDelete = null;

        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Failed!',
                'text' => 'The selected line can not be deleted from this budget!',
            ]);
        }
    }
    public function redirectRequest()  {
        return redirect()->signedRoute('finance-budget_view', $this->budgetCode);
    }
    public function render()
    {
        $data['budget_data'] = $budgetData = $this->budgetData;
        if ($budgetData) {
            // $this->budgetData = $budgetData;
            $data['budget_lines'] = FmsBudgetLine::where('fms_budget_id', $data['budget_data']->id)->get();            
            $data['unitLines'] = FmsUnitBudgetLine::where('is_active', 1)->where('requestable_id', $budgetData->requestable_id)
        ->where('requestable_type', $budgetData->requestable_type)->get();

        } else {
            $data['budget_lines'] = collect([]);
            $data['unitLines'] = collect([]);
        }
        if($budgetData->status =='Submitted' || $budgetData->status =='Approved'){
        //    $this->redirectRequest();
        }
        $chartOfAccts = FmsChartOfAccount::where('is_active', 1)->with(['type']);
        $data['incomes'] = $chartOfAccts->where('account_type', 4)->get();
        $data['expenses'] = FmsChartOfAccount::where('is_active', 1)->with(['type'])->where('account_type', 3)->get();
        return view('livewire.finance.budget.fms-budget-lines-component', $data);
    }
}
