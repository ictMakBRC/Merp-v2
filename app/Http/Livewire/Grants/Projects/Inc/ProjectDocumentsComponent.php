<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;

class ProjectDocumentsComponent extends Component
{
    public $project_id;
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public function storeDocument(){
        
    }

    public function render()
    {
        return view('livewire.grants.projects.inc.project-documents-component');
    }
}
