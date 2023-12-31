<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement;

use Response;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Enums\ProcurementRequestEnum;
use App\Models\Documents\FormalDocument;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestApproval;
use App\Jobs\Procurement\SendProcRequestChainOfCustodyNotification;

class ProcurementBidManagementComponent extends Component
{
    use WithFileUploads;

    //Active Tab toggle
    public $activeTab = 'summary-information';
    
    public $request_id;
    public $comment;

    //SUPPORT DOCUMENTS
    public $document_category;
    public $expires=0;
    public $expiry_date=null;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

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

    public function resetInputs(){
        $this->reset(['comment']);
    }

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers')->findOrFail($this->request_id);
        $data['document_categories'] = DmCategory::all();

        return view('livewire.procurement.requests.procurement.procurement-bid-management-component',$data);
    }
}
