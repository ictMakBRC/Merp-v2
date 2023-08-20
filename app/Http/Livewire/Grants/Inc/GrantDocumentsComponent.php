<?php

namespace App\Http\Livewire\Grants\Inc;

use Livewire\Component;

class GrantDocumentsComponent extends Component
{
    public $grand_profile_id;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public function storeDocument(){
        
    }
    
    public function render()
    {
        return view('livewire.grants.inc.grant-documents-component');
    }
}
