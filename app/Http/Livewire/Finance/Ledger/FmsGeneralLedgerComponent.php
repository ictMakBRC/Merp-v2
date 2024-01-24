<?php

namespace App\Http\Livewire\Finance\Ledger;

use App\Models\Finance\Transactions\FmsTransaction;
use Livewire\Component;

class FmsGeneralLedgerComponent extends Component
{
    public $ledger_id;
    public $from_date;

    public $to_date;

    public $accountIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;

    public $transaction_type;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    
function generalLedger()  {
    $ledgerEntries = FmsTransaction::with('budgetLine.chartOfAccount')
    ->when($this->from_date != '' && $this->to_date != '', function ($query) {
        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
    })  // Adjust this based on your reporting period
    // ->where('trx_type', 'Expense')  // Only consider expenses for this example
    ->get();

// Group entries by Chart of Account type and name
// return $groupedEntries = $ledgerEntries->where('trx_type', 'Expense')->groupBy(function ($entry) {
//     return $entry->budgetLine->chartOfAccount->name;
// });

return $groupedEntries = $ledgerEntries->where('trx_type', 'Expense')->groupBy(function ($entry) {
    $chartOfAccount = $entry->budgetLine->chartOfAccount;
    return $data = [
        'account_id' => $chartOfAccount->id,
        'account_name' => $chartOfAccount->name,
    ];
});

// Loop through the grouped entries and calculate totals
// foreach ($groupedEntries as $accountName => $entries) {
//     $totalAmount = $entries->sum('total_amount');

//     // Output or store the result as needed
//     echo "Account: $accountName, Total: $totalAmount\n";
// }

// $ledger = [];

// // Process each transaction and update the ledger
// foreach ($ledgerEntries as $entry) {
//     $accountName = $entry->budgetLine?->chartOfAccount?->name;
//     $amount = $entry->total_amount*$entry->rate;

//     // Determine if it's a debit or credit based on the transaction type
//     $debit = ($entry->trx_type === 'Expense') ? $amount : null;
//     $credit = ($entry->trx_type === 'Income') ? $amount : null;

//     // Update the ledger array
//     if (!isset($ledger[$accountName])) {
//         $ledger[$accountName] = [
//             'debit' => 0,
//             'credit' => 0,
//             'balance' => 0,
//         ];
//     }

//     // Update the debit, credit, and balance
//     $ledger[$accountName]['debit'] += $debit;
//     $ledger[$accountName]['credit'] += $credit;
//     $ledger[$accountName]['balance'] += ($debit - $credit);
//     return $ledger;
}




    public function render()
    {
    $data['generalLeger'] = $this->generalLedger();
    // dd($data['generalLeger']);
        return view('livewire.finance.ledger.fms-general-ledger-component', $data);
    }
}
