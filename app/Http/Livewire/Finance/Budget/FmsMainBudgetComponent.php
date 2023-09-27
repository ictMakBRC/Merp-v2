<?php

namespace App\Http\Livewire\Finance\Budget;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsChartOfAccount;

class FmsMainBudgetComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $budgetIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $is_active = 1;

    public $edit_id;
    public $fiscal_year;
    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $budget_data;
    public $budget_lines;
    public $budgetData;
    public $expenses;
    public $incomes;
    public function mount($year)
    {
        $this->fiscal_year = $year;
        $this->budget_lines  = collect([]);
        $this->budget_data  = null;
        $this->incomes  = collect([]);
        $this->expenses  = collect([]);
    }
    public function viewDptBudget($id)
    {
        $this->budget_data = $budgetData = FmsBudget::where('id', $id)->first();
        if ($budgetData) {
            $this->budgetData = $budgetData;
            $this->budget_lines = FmsBudgetLine::where('fms_budget_id', $budgetData->id)->get();
        }
        $chartOfAccts = FmsChartOfAccount::where('is_active', 1)->with(['type']);
        $this->incomes  = $chartOfAccts->where('account_type', 4)->get();
        $this->expenses = FmsChartOfAccount::where('is_active', 1)->with(['type'])->where('account_type', 3)->get();
    }
    public function mainQuery()
    {
        $budgets = FmsBudget::search($this->search)->where('fiscal_year', $this->fiscal_year)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->budgetIds = $budgets->pluck('id')->toArray();

        return $budgets;
    }

    public function render()
    {
        $data['budgets'] = $this->mainQuery()->with(['project', 'department','currency','fiscalYear'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        $data['years'] = FmsFinancialYear::all();
        $data['currencies'] = FmsCurrency::all();
        return view('livewire.finance.budget.fms-main-budget-component',$data);
    }
}
