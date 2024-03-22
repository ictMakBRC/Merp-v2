<?php

namespace App\Http\Livewire\Finance\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Invoice\FmsInvoicePayment;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Transactions\FmsTransaction;

class FmsViewCustomerLedgerComponent extends Component
{
    public $from_date;

    public $to_date;

    public $invoiceIds;

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
    public $requestable_id = null;
    public $requestable = null;
    public $department_id;
    public $project_id;
    public $department;
    public $fiscal_year;    
    public $view_invoices = false;
    public $expenses;
    public $payments;
    public $projects;
    public $statements;
    public $tasks;
    public $files;
    public $credit_notes;

    public $unitId;

    function mount($id) {  
        //  $this->invoices = collect([]);
         $this->expenses = collect([]);
         $this->payments = collect([]);
         $this->projects = collect([]);
         $this->statements = collect([]);
         $this->tasks = collect([]);
         $this->files = collect([]);
         $this->credit_notes = collect([]);              
        $this->unitId = $id;
        $this->requestable = $requestable = FmsCustomer::find($id);
        $this->requestable_type =  get_class($requestable);
        $this->requestable_id =  $requestable->id;
        $this->fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();

    }
    function viewInvoices() {
        $view_invoices = true;
    }
    public function transactions()
    {
        $data = FmsInvoicePayment::with('invoice')->WhereHas('invoice', function ($query) {
            $query->where('billtable_id', $this->unitId)->where('billtable_type', $this->requestable_type);
        })->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });


        return $data;
    }
    public function filterInvoices()
    {
        $invoices = FmsInvoice::where('billtable_id', $this->unitId)->where('billtable_type', $this->requestable_type)
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
            ->selectRaw('SUM(payment_amount) AS total_amount')
            ->selectRaw("DATE_FORMAT(as_of, '%M-%Y') display_date")
            ->selectRaw("DATE_FORMAT(as_of, '%Y-%m') new_date")
            ->groupBy('new_date')
            ->orderBy('new_date', 'ASC')
            ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $data['invoice_chart'] = $this->filterInvoices()->select(DB::raw('count(id) as inv_count'), 'status')->groupBy('status')->get();
        $data['invoice_amounts'] = $this->filterInvoices()->whereIn('status',['Partially Paid','Paid','Approved'])->select(DB::raw('sum(total_amount) as amount'), 'status')->groupBy('status')->get();
        $data['expenses'] = $this->transactions()->latest()->limit(10)->get();
        $data['invoices'] = $this->filterInvoices() ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['invoice_counts'] = $this->filterInvoices()->get();
     return view('livewire.finance.customer.fms-view-customer-ledger-component', $data);
}
}