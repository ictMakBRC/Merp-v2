<?php

namespace App\Http\Livewire\Procurement\Requests\ContractsManager;

use Response;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Enums\ProcurementRequestEnum;
use App\Models\Grants\Project\Project;
use App\Models\Documents\FormalDocument;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Services\Finance\Requests\FmsPaymentRequestService;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Jobs\Procurement\SendProcRequestChainOfCustodyNotification;

class ContractsManagerRequestViewComponent extends Component
{
    public $request_id;
    public $comment;
    public $procurementRequest;

    public function mount($id){
        $this->request_id=$id;
    }

    public function approveAndFowardRequest(ProcurementRequest $procurementRequest,$status)
    {
        $this->validate([
            'comment'=>'required|string',
        ]);

        if ($procurementRequest->step_order==7) {
            
            DB::transaction(function () use($procurementRequest,$status) {
                $procurementRequestApproval=ProcurementRequestApproval::where(['procurement_request_id'=>$procurementRequest->id,'step'=>ProcurementRequestEnum::step($procurementRequest->step_order)])->latest()->first();
    
                if($procurementRequest->step_order < ProcurementRequestEnum::TOTAL_STEPS){
                    $procurementRequestApproval->update([
                        'approver_id' => auth()->user()->id,
                        'comment' => $this->comment,
                        'status' => $status,
                    ]);
                
                    $currentStepOrder = $procurementRequest->step_order;
                    $nextStepOrder = $currentStepOrder+1;
    
                    $procurementRequest->update([
                        'status'=>ProcurementRequestEnum::PENDING,
                        'step_order'=>$nextStepOrder,
                    ]);
    
                    ProcurementRequestApproval::create([
                        'procurement_request_id' => $procurementRequest->id,
                        'approver_id' => null,
                        'comment' => null,
                        'status' => ProcurementRequestEnum::PENDING,
                        'step' => ProcurementRequestEnum::step($nextStepOrder),
                    ]);
                    $this->initiatePaymentRequest();
                    
                }else{
                    $procurementRequest->update([
                        'status'=>$status,
                    ]);
    
                    $procurementRequestApproval->update([
                        'approver_id' => auth()->user()->id,
                        'comment' => $this->comment,
                        'status' => $status,
                    ]);
    
                }
            });

            if ($status==ProcurementRequestEnum::PROCESSED) {
                $users= User::whereHas('employee', function($query){
                    $query->where('department_id',auth()->user()->employee->department_id);
                })->get();

                // $users= User::where('id',$procurementRequest->contracts_manager_id)->orWhereHasPermission('process_procurement_request_payment')->get();
        
                SendProcRequestChainOfCustodyNotification::dispatch(ProcurementRequestEnum::step($procurementRequest->step_order-1),$procurementRequest->reference_no, $users);
            }

            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request updated successfully']);
        } else {
            return;
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

        } elseif ($this->procurementRequest->request_type == 'Department') {
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
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payment Request initiatated successfully!']);      

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }
    }
    
    public function acknowledgeRequest(ProcurementRequest $procurementRequest,$status)
    {
        DB::transaction(function () use($procurementRequest,$status) {
            $procurementRequestApproval=ProcurementRequestApproval::where(['procurement_request_id'=>$procurementRequest->id,'step'=>ProcurementRequestEnum::step($procurementRequest->step_order)])->latest()->first();

            $procurementRequest->update([
                'status'=>$status,
            ]);

            $procurementRequestApproval->update([
                'approver_id' => auth()->user()->id,
                'status' => $status,
            ]);
            
        });
        
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request updated successfully']);
        $this->redirect(route('contracts-manager-request-mgt', $procurementRequest->id));
    }
    
    public function downloadDocument(FormalDocument $formalDocument)
    {
        $file = storage_path('app/').$formalDocument->document_path;
        $path_parts = pathinfo($file);
        $filename = $formalDocument->document_name.'.'.$path_parts['extension'];

        if (file_exists($file)) {
            return Response::download($file, $filename);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Document not found!',
            ]);
        }
    }

    public function resetInputs(){
        $this->reset(['comment']);
    }

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers')->findOrFail($this->request_id);
        $this->procurementRequest=$data['request'];
        return view('livewire.procurement.requests.contracts-manager.contracts-manager-request-view-component',$data);
    }
}
