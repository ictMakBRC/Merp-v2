<?php

namespace App\Http\Livewire\Finance\Transfers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Transactions\FmsTransaction;

class FmsTransferComponent extends Component
{ 
    use WithPagination;
    public $from_date;
    
    public $to_date;

    public $serviceIds;

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

    public $is_active =1;
    public $trx_no;
    public $trx_ref;
    public $trx_date;
    public $total_amount;
    public $rate;
    public $department_id;
    public $project_id;
    public $billed_department;
    public $billed_project;
    public $customer_id;
    public $currency_id;
    public $budget_line_id;
    public $income_budget_line_id;
    public $to_account;
    public $trx_type;
    public $entry_type;
    public $from_account;
    public $is_department;
    public $invoiceData;
    public $toAccountData;
    public $fromAccountData;

  public function updatedCreateNew()
        {
            $this->resetInputs();
            $this->toggleForm = false;
        }
    
        public function updatingSearch()
        {
            $this->resetPage();
        }
    
        public function updated($fields)
        {
            $this->validateOnly($fields, [
                'name' => 'required|string',
                'is_active' => 'required|integer',
                'description' => 'nullable|string',
                'sku'=>'required',
            ]);
        }
    
        public function storeTransaction()
        {
            $this->validate([
                'trx_date'=>'required|date',
                'total_amount'=>'required',
                'trx_ref'=>'required',
                'rate'=>'required|numeric',
                'department_id'=>'nullable|integer',
                'project_id'=>'nullable|integer',
                'billed_project'=>'nullable|integer',
                'billed_department'=>'nullable|integer',
                'currency_id'=>'required|integer',
                'budget_line_id'=>'nullable|integer',
                'income_budget_line_id'=>'nullable|integer',
                'to_account'=>'required|integer',
                'from_account'=>'required|integer',
                'description'=>'required|string',    
            ]);

            if ($this->entry_type == 'Project'){
                $this->validate([               
                    'project_id' => 'required|integer',    
                ]);
                $this->department_id = null;
            }elseif($this->entry_type == 'Department'){
                $this->validate([               
                    'department_id' => 'required|integer',    
                ]);
                $this->project_id = null;
            }  
            if($this->to_account == $this->from_account){
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! invalid transaction!',
                    'text' => 'Please select different accounts!',
                ]);
                return false;
            }

            $total_amount = (float) str_replace(',', '', $this->total_amount);
    
            $trans = new FmsTransaction();
            $trans->trx_no = 'TRX' . GeneratorService::getNumber(7);
            $trans->trx_ref = $this->trx_ref;
            $trans->trx_date = $this->as_of;
            $trans->total_amount = $total_amount;
            $trans->to_account = $this->to_account;
            $trans->from_account = $this->from_account;
            $trans->rate = $this->rate;
            $trans->department_id =  $this->department_id;
            $trans->project_id = $this->project_id;
            $trans->billed_department = $this->billed_department;
            $trans->billed_project = $this->billed_project;
            $trans->budget_line_id = $this->budget_line_id;
            $trans->income_budget_line_id = $this->income_budget_line_id;
            $trans->currency_id = $this->currency_id;
            $trans->trx_type = 'Transfer';
            $trans->entry_type = 'Internal';
            if($this->project_id != null){                    
                $trans->is_department = false;
            }
            $trans->save();
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Transfer created successfully!']);
        }
        function updatedTotalAmount(){
            
        }

        function updatedFromAccount(){
            $this->fromAccountData = FmsLedgerAccount::where('id', $this->from_account)->with(['project', 'department','currency'])->first();
        }
        function updatedToAccount(){
            $this->toAccountData = FmsLedgerAccount::where('id', $this->to_account)->with(['project', 'department','currency'])->first();
        }
    
        public function editData(FmsTransaction $service)
        {
            $this->edit_id = $service->id;
            

            $this->createNew = true;
            $this->toggleForm = true;
        }
    
        public function close()
        {
            $this->createNew = false;
            $this->toggleForm = false;
            $this->resetInputs();
        }
    
        public function resetInputs()
        {
            $this->reset([  
           
                'trx_no',
                'trx_ref',
                'trx_date',
                'total_amount',
                'rate',
                'department_id',
                'project_id',
                'billed_department',
                'billed_project',
                'customer_id',
                'currency_id',
                'budget_line_id',
                'account_id',
                'trx_type',
                'entry_type',
                'status',
                'description',
                'is_department',
            ]);
        }
    
        public function refresh()
        {
            return redirect(request()->header('Referer'));
        }
    
        public function export()
        {
            if (count($this->serviceIds) > 0) {
                // return (new servicesExport($this->serviceIds))->download('services_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
            } else {
                $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! Not Found!',
                    'text' => 'No services selected for export!',
                ]);
            }
        }
    
        public function mainQuery()
        {
            $services = FmsTransaction::search($this->search)->where('trx_type','Transfer')
                ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                    $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                }, function ($query) {
                    return $query;
                });
    
            $this->serviceIds = $services->pluck('id')->toArray();
    
            return $services;
        }
    
        public function render()
        {
            $data['transfers'] = $this->mainQuery()
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
            $data['currencies'] = FmsCurrency::where('is_active', 1)->get();


        return view('livewire.finance.transfers.fms-transfer-component',$data);
    }
}
