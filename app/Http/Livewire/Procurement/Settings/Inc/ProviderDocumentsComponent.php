<?php

namespace App\Http\Livewire\Procurement\Settings\Inc;

use Livewire\Component;

class ProviderDocumentsComponent extends Component
{
     //PROVIDER DOCUMENTS
    public $provider_id;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public function storeDocument(){
        
    }


    public function render()
    {
        return view('livewire.procurement.settings.inc.provider-documents-component');
    }
}
