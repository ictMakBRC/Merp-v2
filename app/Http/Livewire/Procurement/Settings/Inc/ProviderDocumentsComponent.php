<?php

namespace App\Http\Livewire\Procurement\Settings\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Models\Procurement\Settings\Provider;
use App\Services\Document\FormalDocumentService;

class ProviderDocumentsComponent extends Component
{
    use WithFileUploads;
    
    public $provider_id;
    public $document_category;
    public $expires=0;
    public $expiry_date=null;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    protected $listeners = [
        'providerCreated' => 'setProviderId',
    ];

    public function setProviderId($details)
    {
        $this->provider_id = $details['providerId'];
    }

    public function storeDocument()
    {
        if ($this->provider_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Provider has been selected for this operation!',
            ]);
            return;
        }

        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){
            $provider = Provider::findOrFail($this->provider_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$provider->name.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('provider_documents', $documentName);
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
            $document = $formalDocumentService->createFormalDocument($provider,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['providers'] = Provider::where('is_active',true)->get();
        $data['document_categories'] = DmCategory::all();
        return view('livewire.procurement.settings.inc.provider-documents-component',$data);
    }
}
