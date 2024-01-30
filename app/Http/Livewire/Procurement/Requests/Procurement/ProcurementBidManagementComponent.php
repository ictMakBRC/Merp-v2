<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement;

use Response;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Enums\ProcurementRequestEnum;
use App\Models\Grants\Project\Project;
use App\Models\Documents\FormalDocument;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Services\Finance\Requests\FmsPaymentRequestService;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Jobs\Procurement\SendProcRequestChainOfCustodyNotification;

class ProcurementBidManagementComponent extends Component
{
    use WithFileUploads;

    //Active Tab toggle
    public $activeTab = 'summary-information';
    
    public $request_id;
    public $procurementRequest;
    public $comment;

    //SUPPORT DOCUMENTS
    public $document_category;
    public $expires=0;
    public $expiry_date=null;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public $net_payment;
    public $payment_description;
    public $read_only=false;

    public function mount($id){
        $this->request_id = $id;
    }

    public function storeSupportDocument()
    {
        if ($this->request_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Procurement Request has been selected for this operation!',
            ]);
            return;
        }

        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){
            $procurementRequest = ProcurementRequest::findOrFail($this->request_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$procurementRequest->reference_no.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('procurement_request_documents', $documentName);
            } else {
                $this->document_path = null;
            }
            
            $formalDocumentDTO = FormalDocumentData::from([
                'document_category'=>$this->document_category,
                'expires'=>$this->expires,
                'expiry_date'=>$this->expiry_date,
                'document_name'=>$this->document_name,
                'document_path'=>$this->document_path,
                'description'=>$this->description,

                ]
            );
  
            $formalDocumentService = new FormalDocumentService();
            $document = $formalDocumentService->createFormalDocument($procurementRequest,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }
    
    public function updateRequest(ProcurementRequest $procurementRequest,$status)
    {
        $this->validate([
            'comment'=>'required|string',
        ]);

        if ($procurementRequest->step_order==6) {
            
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

                // $users= User::where('id',$procurementRequest->contracts_manager_id)->orWhereHasPermission('receive_procurement_request_items')->get();
        
                SendProcRequestChainOfCustodyNotification::dispatch(ProcurementRequestEnum::step($procurementRequest->step_order-1),$procurementRequest->reference_no, $users);
            }

            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request updated successfully']);
        } else {
            return;
        }
       
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

    public function initiatePaymentRequest()
    {
        $this->validate([
            'net_payment'=>'required|numeric|gt:0|lte:'.(100-$this->procurementRequest?->payment_requests?->sum('net_payment_terms')),
            'payment_description'=>'required|string',
        ]);

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

        // $exists = FmsPaymentRequest::where('procurement_request_id', $this->procurementRequest->id)->first();
    
        // if ($exists) {

        //     $this->dispatchBrowserEvent('swal:modal', [
        //         'type' => 'warning',
        //         'message' => 'Oops! Payment Request already exists!',
        //         'text' => 'Payment request for this procurement request is already in the Queue',
        //     ]);
        //     return;
        // }

        try{
            $requestData = [
                'request_type' => 'Procurement',
                'request_description' =>$this->payment_description,
                'rate'=>exchangeRate($currency_id),
                'project_id'=>$project_id,
                'department_id'=>$department_id,
                'currency_id'=>$currency_id,
                'ledger_account'=>$ledger_account,
                'budget_line_id'=>$budget_line_id,
                'requestable'=>$requestable,
                'procurement_request_id'=>$this->request_id,
                'total_amount'=> $this->procurementRequest->contract_value,
                'net_payment_terms'=> $this->net_payment,
            ];

            $paymentRequestService= new FmsPaymentRequestService();
            // Call the service to create the payment request
            $saveData = $paymentRequestService->createPaymentRequest($requestData);
            $this->procurementRequest->update([
                'net_payment_terms'=>$this->procurementRequest->net_payment_terms+$this->net_payment,
            ]);
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Upfront/Advance Payment Request initiated successfully!']);      

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something went wrong!',
                'text' => 'Failed to save due to this error '.$e->getMessage(),
            ]);
        }
    }

    public function resetInputs(){
        $this->reset(['comment']);
    }

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers','payment_requests')->findOrFail($this->request_id);
        $data['document_categories'] = DmCategory::all();
        $this->procurementRequest=$data['request'];
        if ($data['request']->payment_requests->isEmpty() && $data['request']->net_payment_terms>0) {
            $this->net_payment=$data['request']->net_payment_terms;
            $this->read_only=true;
        } else {
            $this->net_payment=100-$data['request']?->payment_requests?->sum('net_payment_terms');
            $this->read_only=false;
        }
        
        // dd($this->procurementRequest=$data['request']->payment_requests);

        return view('livewire.procurement.requests.procurement.procurement-bid-management-component',$data);
    }
}
