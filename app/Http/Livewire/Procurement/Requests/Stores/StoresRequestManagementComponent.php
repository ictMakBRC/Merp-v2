<?php

namespace App\Http\Livewire\Procurement\Requests\Stores;

use Response;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Documents\FormalDocument;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;
use App\Models\Procurement\Request\ProcurementRequest;

class StoresRequestManagementComponent extends Component
{
    use WithFileUploads;

    //Active Tab toggle
    public $activeTab = 'summary-information';
    
    public $request_id;
    public $comment;

    //SUPPORT DOCUMENTS
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

     public function mount($id){
        $this->request_id = $id;
    }

    public function storeDocument()
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

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers')->findOrFail($this->request_id);
        $data['document_categories'] = DmCategory::all();

        return view('livewire.procurement.requests.stores.stores-request-management-component',$data);
    }
}
