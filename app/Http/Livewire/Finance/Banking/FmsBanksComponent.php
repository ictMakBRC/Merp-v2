<?php

namespace App\Http\Livewire\Finance\Banking;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Finance\Banking\FmsBank;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Transactions\FmsTransaction;

class FmsBanksComponent extends Component
{
    use WithPagination;

    //Filters
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
    public $name;
    public $description;
    public $account_no;
    public $department_id;
    public $project_id;
    public $opening_balance;
    public $current_balance;
    public $account_type;
    public $as_of;
    public $is_active;
    public $currency_id;
    public $entry_type ='Department';

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'description',
            'account_no',
            'department_id',
            'project_id',
            'opening_balance',
            'current_balance',
            'as_of',
            'is_active',
            'currency_id',
        ]);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string|unique:fms_banks',
            'is_active' => 'required|numeric',
            'account_no' => 'required|unique:fms_banks',
            'currency_id' => 'required|integer',
            'account_type'=>'required',
            'current_balance' => 'required|numeric',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->accountIds) > 0) {
            // return (new accountSubTypeExport($this->accountIds))->download('accountSubType_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No accountSubType selected for export!',
            ]);
        }
    }

    public function storeAccount()
    {

        $this->validate([
            'name' => 'required|string|unique:fms_banks',
            'is_active' => 'required|numeric',
            'account_no' => 'required|unique:fms_banks',            
            'currency_id' => 'required|integer',
            'opening_balance' => 'required',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
            'account_type'=>'required'

        ]);
        DB::transaction(function () {
        $record = null;
        $requestable= null;    

        if($record){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'the selected unit has an account!',
            ]);
            return false;
        }

        $opening_balance = (float) str_replace(',', '', $this->opening_balance);
        $current_balance = (float) str_replace(',', '', $this->current_balance);
        $account = new FmsBank();
        $account->name = $this->name;
        $account->is_active = $this->is_active;
        $account->account_no = $this->account_no;
        $account->currency_id = $this->currency_id;
        $account->type = $this->account_type;
        $account->current_balance = $opening_balance;
        $account->as_of = $this->as_of;
        $account->is_active = $this->is_active;
        $account->notice_text = $this->description;       
        $account->save();
        
        $requestable = FmsBank::where('id',$account->id)->first();
        $incomeTrans = new FmsTransaction();
        $incomeTrans->trx_no = 'TRL' . GeneratorService::getNumber(7);
        $incomeTrans->trx_ref = $account->account_no ?? 'TRF' . GeneratorService::getNumber(7);;
        $incomeTrans->trx_date = date('Y-m-d');
        $incomeTrans->total_amount = $account->current_balance;
        $incomeTrans->account_amount = $account->current_balance; 
        $incomeTrans->account_balance = $account->current_balance;
        $incomeTrans->bank_id = $account->id;
        $incomeTrans->rate = 1;
        $incomeTrans->currency_id = $account->currency_id;
        $incomeTrans->trx_type = 'Income';
        $incomeTrans->status = 'Approved';
        $incomeTrans->description = 'Unit initial Income deposit';
        $incomeTrans->entry_type = 'Internal';
        $incomeTrans->requestable()->associate($requestable);
        $incomeTrans->save();
    });
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'account created successfully!']);
    }

    public function updateAccount()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_banks,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'account_no' => 'required|unique:fms_banks,account_no,'.$this->edit_id.'',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            // 'account_type' => 'required|integer',
            'opening_balance' => 'required',
            'current_balance' => 'required',
            'as_of' => 'required|date',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',

        ]);

        
        $opening_balance = (float) str_replace(',', '', $this->opening_balance);
        $current_balance = (float) str_replace(',', '', $this->current_balance);

        $account = FmsBank::where('id',$this->edit_id)->first();
        $account->name = $this->name;
        $account->is_active = $this->is_active;
        $account->account_no = $this->account_no;
        // $account->opening_balance = $opening_balance;
        // $account->current_balance = $current_balance;
        // $account->account_type = $this->account_type;
        // $this->account_type = $account->account_type;
        $account->as_of = $this->as_of;
        $account->is_active = $this->is_active;
        $account->notice_text = $this->description;
        $account->update();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'account created successfully!']);
    }

    public function editData(FmsBank $account)
    {
        $this->edit_id = $account->id;
        $this->name = $account->name;
        $this->is_active = $account->is_active;
        $this->account_no = $account->account_no;
        $this->currency_id = $account->currency_id;
        $this->current_balance = $account->current_balance;
        $this->as_of = $account->as_of;
        $this->is_active = $account->is_active;
        $this->description = $account->notice_text;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function filterAccount()
    {
        $accountSubType = FmsBank::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->accountIds = $accountSubType->pluck('id')->toArray();

        return $accountSubType;
    }

    public function render()
    {
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['accounts'] = $this->filterAccount()->where('is_active', 1)->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.finance.banking.fms-banks-component', $data);
    }
}
