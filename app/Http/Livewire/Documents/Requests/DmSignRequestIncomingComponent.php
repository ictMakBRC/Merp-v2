<?php

namespace App\Http\Livewire\Documents\Requests;

use App\Models\Documents\Requests\DmSignatureRequest;
use App\Models\Documents\Requests\DmSignatureRequestDoc;
use Livewire\Component;
use Livewire\WithPagination;

class DmSignRequestIncomingComponent extends Component
{
    use  WithPagination;
    public $perPage = 10;

    public $search = '';
    public $orderBy = 'id';
    protected $paginationTheme = 'bootstrap';

    public function incomingRequests()
    {
        // Retrieve the list of DocumentRequests from the database
        $documentRequests = DmSignatureRequest::all();

        // Loop through each DocumentRequest
        foreach ($documentRequests as $documentRequest) {
            // Eager load the associated Documents with Signatories
            $documentRequest->load('documents.signatories');

            // Filter the Signatories to only include those associated with the current DocumentRequest
            $filteredSignatories = $documentRequest->documents->flatMap(function ($document) use ($documentRequest) {
                return $document->signatories->filter(function ($signatory) use ($documentRequest) {
                    return $signatory->document->request_id === $documentRequest->id;
                });
            });

            // Associate the filtered Signatories with the current DocumentRequest
            $documentRequest->setRelation('signatories', $filteredSignatories);
        }

            // Return the list of DocumentRequests with associated Documents and filtered Signatories
            return $documentRequests;

    }
    public function render()
    {
        // $data['incoming'] = $this->incomingRequests();
        $data['incomingRequsests'] = DmSignatureRequest::search($this->search)->with('documents')
        ->WhereHas('documents.signatories', function ($query) {
            $query->where('signatory_id', auth()->user()->id);
        })->where('status','!=','Pending')->orderBy('id','DESC')->get();

        $data['submited_requets'] = DmSignatureRequest::where('status','!=','Pending')->WhereHas('documents.signatories', function ($query) {
            $query->where('signatory_id', auth()->user()->id);})->get();
        $data['submited_documents'] = DmSignatureRequestDoc::where('status','!=','Pending')->WhereHas('signatories', function ($query) {
            $query->where('signatory_id', auth()->user()->id);})->get();
        return view('livewire.documents.requests.dm-sign-request-incoming-component',$data);
    }
}
