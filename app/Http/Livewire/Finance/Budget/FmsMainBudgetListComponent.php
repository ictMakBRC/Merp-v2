<?php

namespace App\Http\Livewire\Finance\Budget;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;

class FmsMainBudgetListComponent extends Component
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

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public function mainQuery()
    {
        $budgets = FmsBudget::search($this->search)
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
    $data['budgets'] = $this->mainQuery()->with(['fiscalYear'])->select('fiscal_year', DB::raw('sum(esitmated_income) as total_income'), DB::raw('sum(estimated_expenditure) as total_expenses'))
        ->orderBy('fiscal_year', 'desc')->groupBy('fiscal_year')
        ->paginate($this->perPage);
    $data['departments'] = Department::all();
    $data['projects'] = Project::all();
    $data['years'] = FmsFinancialYear::all();
    $data['currencies'] = FmsCurrency::all();
        return view('livewire.finance.budget.fms-main-budget-list-component',$data);
    }
}
