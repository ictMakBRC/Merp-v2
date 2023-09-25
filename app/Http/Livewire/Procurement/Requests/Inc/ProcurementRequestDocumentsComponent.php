<?php

namespace App\Http\Livewire\Procurement\Requests\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;
use App\Models\Procurement\Request\ProcurementRequest;

class ProcurementRequestDocumentsComponent extends Component
{
    use WithFileUploads;
    
    public $procurement_request_id;
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public $loadingInfo;

    protected $listeners = [
        'procurementRequestCreated' => 'setprocurementRequestId',
        'loadProcurementRequest',
    ];

    public function setprocurementRequestId($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];
    }

    public function loadProcurementRequest($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];
        $this->render();

    }

    public function storeDocument()
    {
        if ($this->procurement_request_id==null) {
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
            $procurementRequest = ProcurementRequest::findOrFail($this->procurement_request_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$procurementRequest->reference_no.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('procurement_request_documents/', $documentName);
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
    
    public function render()
    {
        $data['document_categories'] = DmCategory::all();
        return view('livewire.procurement.requests.inc.procurement-request-documents-component',$data);
    }
}
