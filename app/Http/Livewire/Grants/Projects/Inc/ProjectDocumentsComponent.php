<?php

namespace App\Http\Livewire\Grants\Projects\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Services\Document\FormalDocumentService;
use Livewire\WithFileUploads;

class ProjectDocumentsComponent extends Component
{
    use WithFileUploads;
    
    public $project_id;
    public $document_category;
    public $expires;
    public $expiry_date;
    public $document_name;
    public $document;
    public $document_path;
    public $description;

    public $doc;
    public $loadingInfo='';

    protected $listeners = [
        'projectCreated' => 'setProjectId',
        'loadProject' => 'setProjectId',
    ];

    public function setProjectId($details)
    {
        $this->project_id = $details['projectId'];
    }

    public function storeDocument()
    {
        if ($this->project_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Project/Study has been selected for this operation!',
            ]);
            return;
        }

        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){
            $project = Project::findOrFail($this->project_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$project->project_code.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('project_documents', $documentName);
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
            $document = $formalDocumentService->createFormalDocument($project,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }

    // public function updateDocument()
    // {
    //     $formalDocumentDTO = new FormalDocumentData();
    //     $this->validate($formalDocumentDTO->rules());

    //     DB::transaction(function (){

    //         $formalDocumentDTO = FormalDocumentData::from([
  
    //             ]
    //         );
  
    //         $formalDocumentService = new FormalDocumentService();

    //         $project = $formalDocumentService->updateFormalDocument($this->document,$formalDocumentDTO);
   
    //         $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document updated successfully']);

    //         $this->reset($formalDocumentDTO->resetInputs());

    //     });
    // }

    public function render()
    {
        $data['projects'] = Project::where('end_date','>',today())->get();
        $data['document_categories'] = DmCategory::all();
        return view('livewire.grants.projects.inc.project-documents-component', $data);
    }
}
