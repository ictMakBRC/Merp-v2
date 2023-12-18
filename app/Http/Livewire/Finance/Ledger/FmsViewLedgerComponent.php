<?php

namespace App\Http\Livewire\Finance\Ledger;

use Livewire\Component;
use App\Models\Finance\Budget\FmsUnitBudgetLine;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\Finance\Accounting\FmsChartOfAccount;

class FmsViewLedgerComponent extends Component
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
    public function mount($id)
    {
        $this->ledger_id = $id;

    }
    public function render()
    {
     
        $data['ledger_account']=  $ledger_account = FmsLedgerAccount::where('id', $this->ledger_id)->with('currency','requestable')->first();
        $data['transaction_types'] = FmsUnitBudgetLine::search($this->search)->where('requestable_id', $ledger_account?->requestable_id)
        ->where('requestable_type', $ledger_account?->requestable_type)->get();
        $data['transactions'] = FmsTransaction::where('ledger_account', $this->ledger_id)->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        })->get();
        return view('livewire.finance.ledger.fms-view-ledger-component',$data);
    }
}
