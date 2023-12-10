<?php

namespace App\Http\Livewire\HumanResource\Settings;

use Response;
use Livewire\Component;
use App\Models\Documents\FormalDocument;
use App\Models\HumanResource\Settings\Department;

class DepartmentProfile extends Component
{
    public $activeTab='financials';
    public $department_id;

    public function mount($id){
        $this->department_id=$id;
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
        $data['department'] = Department::with('employees','dept_supervisor','ast_supervisor','procurementRequests','projects')->findOrFail($this->department_id);
        return view('livewire.human-resource.settings.department-profile',$data);
    }
}
