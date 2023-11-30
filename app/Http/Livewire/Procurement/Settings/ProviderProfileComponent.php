<?php

namespace App\Http\Livewire\Procurement\Settings;

use Response;
use Livewire\Component;
use App\Models\Documents\FormalDocument;
use App\Models\Procurement\Settings\Provider;

class ProviderProfileComponent extends Component
{
    public $provider_id;

    public function mount($id){
        $this->provider_id=$id;
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
        $data['provider'] = Provider::with('procurement_requests')->findOrFail($this->provider_id);
        return view('livewire.procurement.settings.provider-profile-component',$data);
    }
}
