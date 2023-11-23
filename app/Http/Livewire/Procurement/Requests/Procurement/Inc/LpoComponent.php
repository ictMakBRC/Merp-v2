<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use App\Jobs\Procurement\SendLpo;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Services\Finance\Requests\FmsPaymentRequestService;

class LpoComponent extends Component
{
    public $request_id;
    public $procurementRequest;

    public function mount($id){
        $this->request_id=$id;
    }

    public function sendLocalPurchaseOrder(ProcurementRequest $procurementRequest)
    {
        try {
            SendLpo::dispatch($procurementRequest);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'LPO sent',
                'text' => 'LPO been sent successfully',
            ]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Sending failed!',
                'text' => 'Something went wrong and LPO could not be sent. Please try again.',
            ]);
        }
    }

    public function initiatePaymentRequest()
    {
        // dd('YES');
        $requestable = null;
        $department_id = null;
        $project_id = null;
        $ledger_account = null;
        $currency_id = $this->procurementRequest->currency_id;
        $budget_line_id = $this->procurementRequest->budget_line_id;
        
        if ($this->procurementRequest->request_type == 'Project') {
            $department_id = null;
            $requestable = Project::with('ledger')->find($this->procurementRequest->requestable_id);
            $ledger_account = $requestable->ledger->id;

        } elseif ($this->procurementRequest->request_type == 'Departmental') {
            $project_id = null;
            $requestable = Department::with('ledger')->find($this->procurementRequest->requestable_id);
            $ledger_account = $requestable->ledger->id;
        }

        $exists = FmsPaymentRequest::where('procurement_request_id', $this->procurementRequest->id)->first();
    
        if ($exists) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Payment Request already exists!',
                'text' => 'Payment request for this procurement request is already in the Queue',
            ]);
            return;
        }

        try{
            $requestData = [
                'request_type' => 'Procurement',
                'request_description' => 'Payment Request For '.$this->procurementRequest->bestBidders->first()->name.' who is the approved provider for procurement request  with reference #'.$this->procurementRequest->reference_no.' and LPO Number #'.$this->procurementRequest->lpo_no,
                'rate'=>exchangeRate($currency_id),
                'project_id'=>$project_id,
                'department_id'=>$department_id,
                'currency_id'=>$currency_id,
                'ledger_account'=>$ledger_account,
                'budget_line_id'=>$budget_line_id,
                'requestable'=>$requestable,
                'procurement_request_id'=>$this->request_id,
                'total_amount'=> $this->procurementRequest->contract_value,
                'net_payment_terms'=> $this->procurementRequest->net_payment_terms,
            ];

            $paymentRequestService= new FmsPaymentRequestService();
            // Call the service to create the payment request
            $saveData = $paymentRequestService->createPaymentRequest($requestData);  
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Upfront/Advance Payment Request sent successfully!']);      

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }
    }
    
    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','approvals','approvals.approver','bestBidders')->findOrFail($this->request_id);
        $this->procurementRequest=$data['request'];
        return view('livewire.procurement.requests.procurement.inc.lpo-component',$data);
    }
}
