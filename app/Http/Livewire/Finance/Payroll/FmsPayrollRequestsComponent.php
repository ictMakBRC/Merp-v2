<?php

namespace App\Http\Livewire\Finance\Payroll;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Services\Finance\Requests\FmsPaymentRequestService;

class FmsPayrollRequestsComponent extends Component
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

    public $year;
    public $month;
    public $currency_id;
    public $rate;
    public $notice_text;
    public $department_id;
    public $project_id;
    public $budget_line_id;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
        {
            $this->month = now()->format('m');
            $this->year = now()->format('Y');
    }


    public function storePaymentRequest(FmsPaymentRequestService $paymentRequestService)
    {
       

      
        $this->validate([
            'request_type' => 'required',
            'total_amount' => 'required',
            'request_description' => 'required|string',
            'rate' => 'required|numeric',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'budget_line_id' => 'required|integer',
            'ledger_account' => 'required|integer',
            'notice_text' => 'required|string',
        ]);
       
     
     
        $requestable= null;
        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $this->department_id = null;
            $requestable  = Project::find($this->project_id);
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            $this->project_id = null;
            $requestable  = Department::find($this->department_id);
            
        }


        $this->validate([
            'month' => 'required',
            'year' => 'required',
            'currency_id'=>'required',
            'rate'=>'required'
        ]);

        $exists = FmsPaymentRequest::where('requestable_id', $requestable->id)->where('requestable_type', get_class($requestable))
        ->exists();
        
        $record = FmsPaymentRequest::where([ 'month' => $this->month, 'year' => $this->year, 'currency_id'=>$this->currency_id])->first();
        if($record){

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! payroll already exists!',
                'text' => 'Months already paid or in queue',
            ]);
            return false;

        }
        $requestData = [
            'request_type' => $this->requestType,
            'request_description' => $this->requestDescription,
            // Add other fields based on request type
        ];

        // Call the service to create the payment request
        $paymentRequestService->createPaymentRequest($requestData);

        // Additional logic or response handling

        // Clear form fields after submission
        $this->reset();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payroll created successfully!']);
    }

    public function render()
    {

        return view('livewire.finance.payroll.fms-payroll-requests-component');
    }
}
