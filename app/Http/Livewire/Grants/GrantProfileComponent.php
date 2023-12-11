<?php

namespace App\Http\Livewire\Grants;

use Response;
use Livewire\Component;
use App\Models\Grants\Grant;
use App\Models\Documents\FormalDocument;

class GrantProfileComponent extends Component
{
    public $activeTab='financials';
    public $grant_id;

    public function mount($id){
        $this->grant_id=$id;
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

    public function render()
    {
        $data['grant'] = Grant::with('principalInvestigator','procurementRequests','currency')->findOrFail($this->grant_id);
        return view('livewire.grants.grant-profile-component',$data);
    }
}
