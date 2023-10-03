<?php

namespace App\Http\Livewire\Procurement\Store;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;

use App\Services\Document\FormalDocumentService;
use App\Models\Procurement\Request\ProcurementRequest;
use Livewire\WithFileUploads;

class ProcurementItemsReceptionComponent extends Component
{
    use WithFileUploads;

    public $loadingInfo='';
    public $items=[];
    public $procurementRequest;

    protected $rules = [];

    //DOCUMENTS
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public function mount($id){
        $procurementRequest=ProcurementRequest::findOrFail($id);
        $this->procurementRequest=$procurementRequest;
        $this->items = $procurementRequest->items->all();
        // dd($this->items);
        $this->loadingInfo = $procurementRequest->subject.' | '.$procurementRequest->reference_no;
    }


    public function saveChanges()
    {

        // Validate the items before saving
        // $this->validate();

        // Save changes to the database
        foreach ($this->items as $item) {
            $item->save();
        }

        // Optionally, you can show a success message or perform other actions here

        // Clear any temporary changes in the Livewire component
        $this->reset('items');
    }

    protected function rules()
    {
        $rules = [];

        // Define validation rules for each item
        foreach ($this->items as $key=>$item) {
            $rules["items.{$key}.received_status"] = 'required';
            $rules["items.{$key}.quality"] = 'required';
            $rules["items.{$key}.quantity_delivered"] = 'required|integer|min:0|max:' . $item['quantity'];
            // Add more rules as needed
        }

        return $rules;
    }

    public function storeDocument()
    {
        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$this->procurementRequest->reference_no.' '.$this->document_category.'.'.$this->document->extension();
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
            $document = $formalDocumentService->createFormalDocument($this->procurementRequest,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['document_categories'] = DmCategory::all();
        return view('livewire.procurement.store.procurement-items-reception-component',$data);
    }
}
