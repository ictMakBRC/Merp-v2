<?php

namespace App\Http\Livewire\Finance\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Transactions\FmsTransaction;

class FmsUnitDashboardComponent extends Component
{
    use WithPagination;
            
    //Filters
    public $from_date;

    public $to_date;

    public $lineIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active =1;

    public $description;

    public $account_id;
    public $type;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $requestable_type = null;
    public $requestable = null;
    public $department_id;
    public $project_id;
    public $department;

    public $unitId;

    function mount($id, $type) {                
        $this->unitId = $id;
        if($type == 'department'){
            $this->requestable = $requestable = Department::find($id);            
            $this->department_id =$id;
            $this->requestable_type =  get_class($requestable);
        }elseif($type == 'project'){
            $this->project_id = $id;
            $this->requestable_type  = 'App\Models\Grants\Project\Project';
            $this->requestable =  Project::find($id);
        }

    }
    public function transactions()
    {
        $data = FmsTransaction::where('requestable_id', $this->unitId)
        ->where('requestable_type', $this->requestable_type)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->lineIds = $data->pluck('id')->toArray();

        return $data;
    }
    public function filterInvoices()
    {
        $invoices = FmsInvoice::where('requestable_id', $this->unitId)->where('requestable_type', $this->requestable_type)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        // $this->invoiceIds = $invoices->pluck('id')->toArray();

        return $invoices;
    }
    public function render()
    {
        
    //   dd(auth()->user()->employee->department_id);
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
     
            $data['transactions_chart'] = $this->transactions()
            // ->selectRaw('SUM(CASE WHEN trx_type = "Income" THEN (total_amount * rate) ELSE 0 END) AS total_income')            
            ->selectRaw('SUM(CASE WHEN trx_type = "Income" THEN amount_local ELSE 0 END) AS total_income')
            ->selectRaw('SUM(CASE WHEN trx_type = "Expense" THEN amount_local ELSE 0 END) AS total_expense')
            ->selectRaw("DATE_FORMAT(trx_date, '%M-%Y') display_date")
            ->selectRaw("DATE_FORMAT(trx_date, '%Y-%m') new_date")
            ->groupBy('new_date')
            ->orderBy('new_date', 'ASC')
            ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $data['invoice_chart'] = $this->filterInvoices()->select(DB::raw('count(id) as inv_count'), 'status')->groupBy('status')->get();
        $data['invoice_amounts'] = $this->filterInvoices()->whereIn('status',['Partially Paid','Paid','Approved'])->select(DB::raw('sum(total_amount) as amount'), 'status')->groupBy('status')->get();
        $data['incomes'] = $this->transactions()->where('trx_type', 'Income')->latest()->limit(10)->get();
        $data['expenses'] = $this->transactions()->where('trx_type', 'Expense')->latest()->limit(10)->get();
        return view('livewire.finance.dashboard.fms-unit-dashboard-component', $data);
    }
}
