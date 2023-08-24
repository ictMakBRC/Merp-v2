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
        'switchProject' => 'setProjectId',
    ];

    public function setProjectId($details)
    {
        $this->project_id = $details['projectId'];
        $this->loadingInfo = $details['info'];
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

            $formalDocumentDTO = FormalDocumentData::from([
                
                ]
            );
  
            $project = Project::findOrFail($this->project_id);
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
