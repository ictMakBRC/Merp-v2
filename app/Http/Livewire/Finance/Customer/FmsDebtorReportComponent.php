<?php

namespace App\Http\Livewire\Finance\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Invoice\FmsInvoice;

class FmsDebtorReportComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $customerIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'created_at';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;
    public $type;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $account_number;
    public $title;
    public $name;
    public $first_name;
    public $other_name;
    public $gender;
    public $nationality;
    public $address;
    public $city;
    public $email;
    public $alt_email;
    public $contact;
    public $fax;
    public $alt_contact;
    public $website;
    public $company_name;
    public $payment_terms;
    public $payment_methods;
    public $opening_balance;
    public $sales_tax_registration;
    public $as_of;
    public $is_active = 1;
    public $created_by;
    public $parent_id;
    public $code;
    function mainQuery()  {
        return FmsInvoice::search($this->search)
        ->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        })->where('status', '!=', 'Fully Paid')
        ->groupBy('billtable_type', 'billtable_id')->with('billtable')
        ->selectRaw(' billtable_type, billtable_id,  
            SUM( total_amount*rate - total_paid*rate - adjustment*rate) AS total_debt_amount,
            SUM(CASE
                WHEN due_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 1 DAY THEN total_amount*rate - total_paid*rate - adjustment*rate
                ELSE 0 END) AS aging_30_days,
            SUM(CASE
                WHEN due_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 31 DAY THEN total_amount*rate - total_paid*rate - adjustment*rate
                ELSE 0 END) AS aging_31_60_days,
            SUM(CASE
                WHEN due_date BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE() - INTERVAL 61 DAY THEN total_amount*rate - total_paid*rate - adjustment*rate
                ELSE 0 END) AS aging_61_90_days,
            SUM(CASE
            WHEN due_date BETWEEN CURDATE() - INTERVAL 9000 DAY AND CURDATE() - INTERVAL 91 DAY THEN total_amount*rate - total_paid*rate - adjustment*rate
                ELSE 0 END) AS aging_91_days');
    }
    public function render()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        $data['debtors'] = $this->mainQuery()->paginate($this->perPage);
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

        return view('livewire.finance.customer.fms-debtor-report-component', $data);
    }
}
