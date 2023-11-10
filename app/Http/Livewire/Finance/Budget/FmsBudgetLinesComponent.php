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
    public function mount($budget)
    {
        $this->budgetCode = $budget;

    }
    function updatedLineId(){
     $budgetLine =   FmsUnitBudgetLine::where('id', $this->line_id)->first();
    //  dd($budgetLine);
     if($budgetLine){
        $this->name = $budgetLine->name;
        $this->description = $budgetLine->description;
     }
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
        $record = FmsBudgetLine::where(['fms_budget_id'=>$this->budgetData->id, 'line_id'=>$this->line_id])->first();
        if($record){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'the selected line already exists on this budget!',
            ]);
            return false;
        }
        $line_id = $this->line_id;
        // $budgetName = $this->name[$id];
        $budgetAmount = $this->allocated_amount[$id];
        $description = $this->description[$id];
        $quantity = $this->quantity[$id];
        if($this->type =='Revenue'){
            $primaryAmount = 0;
        }else{
            $primaryAmount = $this->allocated_amount[$id];
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
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget-line item created successfully!']);
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
        ]);
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
                $budgetData->esitmated_income = $totalIncome;
                $budgetData->status = 'Saved';
                $budgetData->update();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget saved successfully!']);
                return redirect()->signedRoute('finance-budget_view', $this->budgetCode);
            }
        });
    }

    public function deleteRecord()
    {

        FmsBudgetLine::find($this->budgetToDelete)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Budget-line item deleted successfully!']);
        $this->confirmingDelete = false;
        $this->budgetToDelete = null;
    }
    public function render()
    {
        $data['budget_data'] = $budgetData = FmsBudget::where('code', $this->budgetCode)->first();
        if ($budgetData) {
            $this->budgetData = $budgetData;
            $data['budget_lines'] = FmsBudgetLine::where('fms_budget_id', $data['budget_data']->id)->get();            
            $data['unitLines'] = FmsUnitBudgetLine::where('is_active', 1)->where('requestable_id', $budgetData->requestable_id)
        ->where('requestable_type', $budgetData->requestable_type)->get();

        } else {
            $data['budget_lines'] = collect([]);
            $data['unitLines'] = collect([]);
        }
        $chartOfAccts = FmsChartOfAccount::where('is_active', 1)->with(['type']);
        $data['incomes'] = $chartOfAccts->where('account_type', 4)->get();
        $data['expenses'] = FmsChartOfAccount::where('is_active', 1)->with(['type'])->where('account_type', 3)->get();
        return view('livewire.finance.budget.fms-budget-lines-component', $data);
    }
}
