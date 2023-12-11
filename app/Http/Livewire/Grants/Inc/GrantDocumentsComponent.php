<?php

namespace App\Http\Livewire\Grants\Inc;

use Livewire\Component;
use App\Models\Grants\Grant;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;

class GrantDocumentsComponent extends Component
{
    use WithFileUploads;
    
    public $grant_id;
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    protected $listeners = [
        'grantCreated' => 'setGrantId',
        'loadGrant' => 'setGrantId',
    ];

    public function setGrantId($details)
    {
        $this->grant_id = $details['grantId'];
    }

    public function storeDocument()
    {
        if ($this->grant_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Grant has been selected for this operation!',
            ]);
            return;
        }

        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){
            $grant = Grant::findOrFail($this->grant_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$grant->grant_code.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('grant_documents', $documentName);
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
            $document = $formalDocumentService->createFormalDocument($grant,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['grants'] = Grant::where('end_date','>',today())->get();
        $data['document_categories'] = DmCategory::all();
        return view('livewire.grants.inc.grant-documents-component',$data);
    }
}
