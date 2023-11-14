<?php

namespace App\Http\Livewire\Finance\Ledger;

use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;
use Livewire\Component;

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
        $data['ledger_account']= FmsLedgerAccount::where('id', $this->ledger_id)->with('currency','requestable')->first();
        $data['transactions'] = FmsTransaction::where('ledger_account', $this->ledger_id)->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        })->get();
        return view('livewire.finance.ledger.fms-view-ledger-component',$data);
    }
}
