<?php

namespace App\Http\Livewire\Finance\Budget;

use Livewire\Component;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Accounting\FmsChartOfAccount;

class FmsViewBudgetComponent extends Component
{
    public $budgetData;
    public $budgetCode;
    public function mount($budget)
    {
        $this->budgetCode = $budget;

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
