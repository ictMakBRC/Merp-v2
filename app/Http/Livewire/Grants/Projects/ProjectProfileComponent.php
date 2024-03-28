<?php

namespace App\Http\Livewire\Grants\Projects;

use Response;
use Livewire\Component;
use App\Models\Grants\Project\Project;
use App\Models\Documents\FormalDocument;

class ProjectProfileComponent extends Component
{
    public $activeTab='financials';
    public $project_id;

    public function mount($id){
        $this->project_id=$id;
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

    public function downloadContract($filePath){
        try {
            return downloadFile($filePath);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        } 
    }

    public function render()
    {
        $data['project']=Project::with('principalInvestigator','coordinator','procurementRequests','employees','departments','ledger','currency')->findOrFail($this->project_id);
        return view('livewire.grants.projects.project-profile-component',$data);
    }
}
