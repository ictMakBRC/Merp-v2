<?php

namespace App\Http\Livewire\Finance\Customer;

use App\Models\Finance\Invoice\FmsInvoice;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FmsDebtorReportComponent extends Component
{
    public function render()
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        $data['debtorsReport'] = FmsInvoice::where('status', '!=', 'Fully Paid')
            ->groupBy('billtable_type', 'billtable_id')->with('billtable')
            ->selectRaw('*, billtable_type,
        billtable_id,   SUM(CASE
        WHEN due_date < CURDATE() - INTERVAL 30 DAY THEN total_amount - total_paid - adjustment
        ELSE 0
    END) AS aging_30_days,
    SUM(CASE
        WHEN due_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 31 DAY THEN total_amount - total_paid - adjustment
        ELSE 0
    END) AS aging_31_60_days,
    SUM(CASE
        WHEN due_date BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE() - INTERVAL 61 DAY THEN total_amount - total_paid - adjustment
        ELSE 0
    END) AS aging_61_90_days
')
            ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");

        return view('livewire.finance.customer.fms-debtor-report-component', $data);
    }
}
