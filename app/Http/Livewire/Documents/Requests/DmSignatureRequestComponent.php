<?php

namespace App\Http\Livewire\Documents\Requests;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Documents\Settings\DmCategory;
use App\Models\Documents\Requests\DmSignatureRequest;
use App\Models\Documents\Requests\DmSignatureRequestDoc;
use App\Models\Documents\Requests\DmSignatureRequestSupportDoc;
use App\Models\Documents\Requests\DmSignatureRequestDocSignatory;

class DmSignatureRequestComponent extends Component
{
    use WithFileUploads, WithPagination;
    public $from_date;

    public $to_date;
    public $filter = false;
    public $perPage = 10;

    public $search = '';

    public $search_folder = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $delete_id;

    public $edit_id;

    public $category_id;

    public $title;

    public $file;

    public $status;

    public $disk;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;
    public $document_id;
    public $active_request;
    public $active_status;
    public $details;
    public $expiry_date;
    public $inputs = [];
    public $name_title;
    public $user_id;
    public $parent_id = 0;
    public $mulitple_identifier, $priority;
    public $documents;
    public $folder_open, $current_folder, $current_folder_name;
    public $addSignatory = false;
    public $addDocument = false;
    public $iteration = 1;
    public $person_exists = false;
    public $exportIds;

    public $signatory_id, $signatory_level, $support_document_title, $support_file, $active_document_id, $summary;

    public $description, $addDocuments = false, $viewForm = true, $request_id, $document_title, $my_document_id;

    public function mount()
    {
        $this->disk = 'Documents';
    }
    public function updatedMyDocumentId()
    {

        $level = DmSignatureRequestDocSignatory::where('document_id', $this->my_document_id)->orderBy('id', 'DESC')->first();
        if ($level) {
            $this->signatory_level = $level->signatory_level + 1;
        } else {
            $this->signatory_level = 1;
        }
    }

    public function storeRequest()
    {
        $this->validate([
            'title' => 'required|string',
            'priority' => 'required',
            'category_id' => 'required',
            'details' => 'nullable|string',
        ]);
        $request = new DmSignatureRequest();
        $request->title = $this->title;
        $request->priority = $this->priority;
        $request->request_code = $this->getNumber(10);
        $request->category_id = $this->category_id;
        $request->description = $this->details;
        $request->save();
        $this->viewForm = false;
        $this->toggleForm = false;
        $this->addDocument = true;
        // $this->document_id = $request->id;
        $this->attachDocument($request->id);
        $this->dispatchBrowserEvent('close-modal');
        //  $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Category created successfully!']);
        // return to_route('document.preview',$document->document_code);
    }

    public function getNumber($length)
    {
        $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function attachDocument($id)
    {
        $this->active_request = $request = DmSignatureRequest::where('id', $id)->with(['category', 'documents', 'user'])->first();
        $this->title = $request->title;
        $this->priority = $request->priority;
        $this->category_id = $request->category_id;
        $this->description = $request->description;
        $this->addDocuments = true;
        $this->toggleForm = true;
        $this->createNew = true;
        $this->viewForm = false;
        $this->request_id = $request->id;
    }

    public function addnewEntry()
    {
        $this->viewForm = true;
        $this->createNew = true;
    }

    public function addDocument()
    {

        $this->validate([
            'file' => 'required|mimes:pdf,docx|max:20240|file|min:10', // 20MB Max
            'document_title' => 'required|string',
        ]);

        $file_name = date('Ymdhis') . '_' . time() . '.' . $this->file->extension();
        $path = date('Y') . '/' . date('M') . '/Requests/Originals';
        $document_path = $this->file->storeAs($path, $file_name, $this->disk);
        $document = new DmSignatureRequestDoc();
        $document->title = $this->document_title;
        $document->document_code = $this->getNumber(12);
        $document->category_id = $this->active_request->category_id;
        $document->request_code = $this->active_request->request_code;
        $document->request_id = $this->active_request->id;
        $document->original_file = $document_path;
        $document->save();
        $this->iteration = rand();
        $this->document_title = null;
        $this->file = null;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Document created successfully!']);

    }

    public function downloadDocument(DmSignatureRequestDoc $document)
    {
        $file = $document->original_file;

        // Check if the file exists
        if (Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->download($document->original_file, $document->title . ' downloaded');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        }

    }

    public function deleteDocument($id)
    {
        try {
            $data = DmSignatureRequestDoc::where('id', $id)->first();
            if ($data) {
                if (count($data->signatories) > 0 || count($data->supportDocuments) > 0) {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'error',
                        'message' => 'Action failed!',
                        'text' => 'File can not be deleted!',
                    ]);
                    return false;
                }
                Storage::disk($this->disk)->delete($data->original_file);
                $data->delete();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Document file deleted successfully!']);
            } else {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'message' => 'Action failed!',
                    'text' => 'File not deleted! please refresh the page and try again!',
                ]);
            }

        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'File not deleted! ' . $error]);
        }
    }

    public function addSupportDocument()
    {

        $this->validate([
            'support_file' => 'required|mimes:pdf,docx|max:20240|file|min:10', // 20MB Max
            'support_document_title' => 'required|string',
        ]);

        $file_name = date('Ymdhis') . '_' . time() . '.' . $this->support_file->extension();
        $path = date('Y') . '/' . date('M') . '/Requests/SupportFiles';
        $document_path = $this->support_file->storeAs($path, $file_name, $this->disk);

        $document = new DmSignatureRequestSupportDoc();
        $document->title = $this->support_document_title;
        $document->document_code = $this->getNumber(12);
        $document->parent_id = $this->my_document_id;
        $document->request_id = $this->active_request->id;
        $document->original_file = $document_path;
        $document->save();
        $this->iteration = rand();
        $this->support_document_title = null;
        $this->support_file = null;
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Document created successfully!']);

    }

    public function downloadSupportDocument(DmSignatureRequestSupportDoc $document)
    {

        $file = $document->original_file;

        // Check if the file exists
        if (Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->download($document->original_file, $document->title . ' downloaded');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        }
    }

    public function deleteSupportDocument($id)
    {
        try {
            $data = DmSignatureRequestSupportDoc::where('id', $id)->first();
            Storage::disk($this->disk)->delete($data->original_file);
            $data->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Document file deleted successfully!']);
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'File not deleted! ' . $error]);
        }
    }

    public function addSignatory()
    {
        $this->validate([
            'name_title' => 'required|string',
            'signatory_id' => 'required|numeric',
        ]);
        $exists = DmSignatureRequestDocSignatory::where(['signatory_id' => $this->signatory_id, 'document_id' => $this->my_document_id])->first();
        // dd($exists);
        if ($exists) {
            $this->person_exists = true;
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Signatory already exists on this particular document, please select another different person']);
        } else {
            $signatory = new DmSignatureRequestDocSignatory();
            $signatory->document_id = $this->my_document_id;
            $level = DmSignatureRequestDocSignatory::where('document_id', $this->my_document_id)->orderBy('id', 'DESC')->first();
            if ($level) {
                $signatory->signatory_level = $level->signatory_level + 1;
            } else {
                $signatory->signatory_level = 1;
                // $signatory->status = 'Active';
                // $signatory->is_active = '1';
            }
            // $signatory->signatory_level = $this->signatory_level;
            $signatory->title = $this->name_title;
            $signatory->signatory_id = $this->signatory_id;
            $signatory->save();
            $this->signatory_level = $signatory->signatory_level + 1;
            $this->name_title = null;
            $this->signatory_id = null;
            $this->summary = null;
            $this->signatory_level = null;
            $this->active_document_id = null;
            $this->person_exists = false;
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Signatory created successfully!']);
        }
    }

    public function deleteSignatory($id)
    {
        $signatory = DmSignatureRequestDocSignatory::Where('id', $id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Signatory removed successfully!']);
    }

    public function submitRequest()
    {
        DB::transaction(function () {

        $myRequest = DmSignatureRequest::where('id', $this->request_id)->with(['documents'])->first();
        // dd($myRequest);
        if ($myRequest && count($myRequest->documents)) {
            // dd($myRequest->documents);
            foreach ($myRequest->documents as $document) {
                $signatory = DmSignatureRequestDocSignatory::Where(['document_id' => $document->id, 'status' => 'Pending'])
                    ->orderBy('signatory_level', 'asc')->first();
                $signatory->update(['status' => 'Active']);
            }
            DmSignatureRequestDoc::where('request_id', $this->request_id)->update(['status' => 'Submitted']);
            DmSignatureRequest::where('id', $this->request_id)->update(['status' => 'Submitted']);
        }

        $this->toggleForm = false;
        $this->createNew = false;
        $this->addDocuments = false;
        $this->addSignatory = false;
        $this->addDocument = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Document submitted successfully!']);
        // return to_route('document.preview',$document->document_code);
    });
    }

    function updatedCreateNew(){
        if($this->createNew ==false){
           $this->resetInputs();
            $this->addDocuments = false;
            $this->toggleForm = false;
            $this->addSignatory = false;
            $this->viewForm = false;
        }else{
            $this->viewForm = true;
        }
    }
    public function resetInputs()
    {
        $this->reset(['title', 'priority', 'description','category_id','request_id']);
    }

    public function mainQuery()
    {
        $query = DmSignatureRequest::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $query->pluck('id')->toArray();

        return $query;
    }

    public function render()
    {
        if ($this->request_id) {
            $data['myRequest'] = DmSignatureRequest::where('id', $this->request_id)->with(['category', 'documents', 'user', 'documents.supportDocuments', 'documents.signatories'])->first();
        } else {
            $data['myRequest'] = [];
        }

        $data['myRequests'] = $this->mainQuery()->where('created_by', auth()->user()->id)->with('category')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['categories'] = DmCategory::where('is_active', 1)->get();
        $data['users'] = User::all();
        return view('livewire.documents.requests.dm-signature-request-component', $data);
    }
}
