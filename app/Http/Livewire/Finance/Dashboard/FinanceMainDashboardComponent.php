<?php

namespace App\Http\Livewire\Finance\Dashboard;

use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Finance\Transactions\FmsTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceMainDashboardComponent extends Component
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

    public $is_active = 1;

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
    public $fiscal_year;
    public $unitId;

    public function mount()
    {
        $this->fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
    }

    public function transactions()
    {
        $data = FmsTransaction::with('requestable')->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        });

        $this->lineIds = $data->pluck('id')->toArray();

        return $data;
    }
    public function paymentRequests()
    {
        $data = FmsPaymentRequest::with('requestable')->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        });

        $this->lineIds = $data->pluck('id')->toArray();

        return $data;
    }
    public function filterInvoices()
    {
        $invoices = FmsInvoice::when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        });

        // $this->invoiceIds = $invoices->pluck('id')->toArray();

        return $invoices;
    }
    public function convertCurrency($amount, $targetCurrency)
    {
        // Fetch the exchange rate from your exchange rate data or API
        $exchangeRate = FmsCurrency::where('id', $targetCurrency)->first();

        // Perform the currency conversion
        $convertedAmount = $amount * $exchangeRate->exchange_rate;

        return $convertedAmount;
    }
    public function budgetQuery()
    {
        $budgets = FmsBudget::where('fiscal_year', $this->fiscal_year->id ?? 0)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        return $budgets;
    }
    public function render()
    {
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
            $data['expenseIncome'] = FmsTransaction::latest()
    ->select('requestable_type', 'requestable_id')
    ->selectRaw('SUM(CASE WHEN trx_type = "Income" THEN total_amount*rate ELSE 0 END) AS total_income')
    ->selectRaw('SUM(CASE WHEN trx_type = "Expense" THEN total_amount*rate ELSE 0 END) AS total_expense')
    ->groupBy('requestable_type', 'requestable_id')
    ->with('requestable')
    ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        $data['invoice_chart'] = $this->filterInvoices()->select(DB::raw('count(id) as inv_count'), 'status')->groupBy('status')->get();
        $data['invoice_amounts'] = $this->filterInvoices()->whereIn('status', ['Partially Paid', 'Paid', 'Approved'])->select(DB::raw('sum(total_amount) as amount'), 'status')->groupBy('status')->get();
        $data['requests'] = $this->paymentRequests()->whereIn('status', ['Approved', 'Completed'])->orderBy('status', 'asc')->latest()->limit(10)->get();
        $data['request_counts'] = $this->paymentRequests()->get();
        $data['transactions_all'] = $this->transactions()->get();
        $data['transactions'] = $this->transactions()->latest()->limit(10)->get();
        $data['budget'] = $this->budgetQuery()->with(['fiscalYear'])->select('fiscal_year', DB::raw('sum(estimated_income_local) as total_income'), DB::raw('sum(estimated_expense_local) as total_expenses'))
            ->groupBy('fiscal_year')->first();
        $data['invoice_counts'] = $this->filterInvoices()->get();
        return view('livewire.finance.dashboard.finance-main-dashboard-component', $data)->layout('layouts.app');
    }
}
