<?php

namespace App\Http\Livewire\Finance\Budget;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
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
    public $departMentBudgets;
    public $projecttBudgets;
    public $financialYear;
    public function mount($year)
    {
        $this->financialYear = FmsFinancialYear::where('id',$year)->first();
        $this->fiscal_year = $year;
        $this->budget_lines  = collect([]);
        $this->budget_data  = null;
        $this->incomes  = collect([]);
        $this->expenses  = collect([]);
        $this->departMentBudgets  = collect([]);
        $this->projecttBudgets  = collect([]);
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

    public function convertCurrency($amount, $targetCurrency)
    {
        // Fetch the exchange rate from your exchange rate data or API
        $exchangeRate = FmsCurrency::where('id', $targetCurrency)->first();

        // Perform the currency conversion
        $convertedAmount = $amount * $exchangeRate->exchange_rate;

        return $convertedAmount;
    }
    public function getDepartMentBudgets($id){
        $this->departMentBudgets = [];
        $this->projecttBudgets = [];
        $budgets = FmsBudget::where('fiscal_year', $this->fiscal_year)->get();
        $departmentalBudgets = [];
        $projectBudgets = [];
    
        foreach ($budgets as $budget) {
            if($budget->department_id){
                // Get the currency of this budget
                $budgetCurrency = $budget->currency->id;
        
                // Iterate through the budget lines associated with this budget
                foreach ($budget->budgetLines->where('chat_of_account', $id) as $budgetLine) {
                    // Get the chart of accounts associated with this budget line
                    $chartOfAccount = $budgetLine->chartOfAccount;
                    $department = $budgetLine->budget->department->name;                
                    $budgetDepartment = $budgetLine->budget->department_id;
                    // Convert the budget line's allocated amount to the base currency
                    $convertedAmount = $this->convertCurrency($budgetLine->allocated_amount, $budgetCurrency);
                    $name = $budgetLine->name;
                    $description = $budgetLine->description;
                
        
                    // Group the converted amount by chart_of_account_id along with chart of account details
                    if (isset($departmentalBudgets[$budgetDepartment])) {
                        $departmentalBudgets[$budgetDepartment]['amount'] += $convertedAmount;
                    } else {
                        $departmentalBudgets[$budgetDepartment] = [
                            'amount' => $convertedAmount,
                            'department' => $department,
                        ];
                    }
                }
            }
            if($budget->project_id){
                // Get the currency of this budget
                $budgetCurrency = $budget->currency->id;
        
                // Iterate through the budget lines associated with this budget
                foreach ($budget->budgetLines->where('chat_of_account', $id) as $budgetLine) {
                    // Get the chart of accounts associated with this project
                    $project = $budgetLine->budget->project->name;                
                    $budgetProject = $budgetLine->budget->project_id;
                    // Convert the budget line's allocated amount to the base currency
                    $convertedProjectAmount = $this->convertCurrency($budgetLine->allocated_amount, $budgetCurrency);
                
        
                    // Group the converted amount by chart_of_account_id along with chart of account details
                    if (isset($projectBudgets[$budgetProject]) && isset($projectBudgets[$budgetProject]['amount'])) {
                        $projectBudgets[$budgetProject]['amount'] += $convertedProjectAmount;
                    } else {
                        $projectBudgets[$budgetProject] = [
                            'project_amount' => $convertedProjectAmount,
                            'project' => $project,
                        ];
                    }
                }
            }
        }
    
        $this->projecttBudgets = $projectBudgets;
        $this->departMentBudgets = $departmentalBudgets;
        // dd($this->departMentBudgets);
    }
    



public function calculateOrganizationalBudget()
{
    $budgets = FmsBudget::where('fiscal_year', $this->fiscal_year)->get();
    $organizationalBudgets = [];

    foreach ($budgets as $budget) {
        // Get the currency of this budget
        $budgetCurrency = $budget->currency->id;

        // Iterate through the budget lines associated with this budget
        foreach ($budget->budgetLines as $budgetLine) {
            // Get the chart of accounts associated with this budget line
            $chartOfAccount = $budgetLine->chartOfAccount;

            // Convert the budget line's allocated amount to the base currency
            $convertedAmount = $this->convertCurrency($budgetLine->allocated_amount, $budgetCurrency);
            $type = $budgetLine->type;
            // Create an array with chart of account details
            $chartOfAccountInfo = [
                'id' => $chartOfAccount->id,
                'name' => $chartOfAccount->name,
            ];

            // Group the converted amount by chart_of_account_id along with chart of account details
            if (isset($organizationalBudgets[$chartOfAccount->id])) {
                $organizationalBudgets[$chartOfAccount->id]['amount'] += $convertedAmount;
            } else {
                $organizationalBudgets[$chartOfAccount->id] = [
                    'amount' => $convertedAmount,
                    'type' => $type,
                    'chartOfAccount' => $chartOfAccountInfo,
                ];
            }
        }
    }

    return $organizationalBudgets;
}



    public function render()
    {
        $data['main_budgets'] = $this->calculateOrganizationalBudget();
        // dd($data['main_budgets']);
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
