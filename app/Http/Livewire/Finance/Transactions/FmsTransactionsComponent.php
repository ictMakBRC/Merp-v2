<?php

namespace App\Http\Livewire\Finance\Transactions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\Finance\Accounting\FmsChartOfAccount;

class FmsTransactionsComponent extends Component
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
    public $trx_type ='0';
    public $unit_type = 'department';
    public $unit_id = 0;
    public $requestable_type;
    public $requestable_id;
    public $requestable;
    public function mount($type)
    {
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->requestable = $requestable = Project::find($this->unit_id);
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->requestable = $requestable = Department::find($this->unit_id);
            }
            if ($requestable) {
                $this->requestable_type = get_class($requestable);
                $this->requestable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }
    }
   
    public function mainQuery()
    {
        $budgets = FmsTransaction::search($this->search)->when($this->requestable_id && $this->requestable_type, function ($query) {
            $query->where(['requestable_id'=> $this->requestable_id,'requestable_type' => $this->requestable_type]);
        })->when($this->trx_type , function ($query) {$query->where(['trx_type'=> $this->trx_type]);})
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
        $data['transactions'] = $this->mainQuery()->with(['project', 'department','currency','requestable'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        $data['years'] = FmsFinancialYear::all();
        $data['currencies'] = FmsCurrency::all();
        return view('livewire.finance.transactions.fms-transactions-component',$data);
    }
}
