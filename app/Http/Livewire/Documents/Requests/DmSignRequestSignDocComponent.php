<?php

namespace App\Http\Livewire\Documents\Requests;

use Throwable;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Documents\Requests\DmSignatureRequest;
use App\Models\Documents\Requests\DmSignatureRequestDoc;
use App\Models\Documents\Requests\DmSignatureRequestSupportDoc;
use App\Models\Documents\Requests\DmSignatureRequestDocSignatory;

class DmSignRequestSignDocComponent extends Component
{
    use WithFileUploads, WithPagination;
    public $requestCode, $active_document_id, $iteration = 1, $signed_file;
    public $action = false;
    public $comments, $support_file, $support_document_title;
    public $active_request;
    public $disk;
    public $documentPath;
    public function mount($code)
    {
        $this->requestCode = $code;
        $this->disk = 'Documents';
        try {
            // $this->active_document_id = DmSignatureRequest::where('request_code', $this->requestCode)->first()->id;
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'File not deleted! ' . $error]);
        }
    }

    public function updatedActiveDocumentId()
    {
        $this->action = false;
    }
public $document_path;
    public function uploadSignedDoc()
    {
        $this->validate([
            'signed_file' => 'required|mimes:pdf,docx|max:20240|file|min:10', // 20MB Max
            // 'support_document_title' => 'required|string',
        ]);

        $data = DmSignatureRequestDocSignatory::Where(['document_id' => $this->active_document_id, 'signatory_id' => auth()->user()->id])->first();

        $file_name = date('Ymdhis') . '_' . time() . '.' . $this->signed_file->extension();
        $path = date('Y') . '/' . date('M') . '/Requests/Signed';
        $document_path = $this->signed_file->storeAs($path, $file_name, $this->disk);
        if ($data->signed_file != null) {
            Storage::disk($this->disk)->delete($data->signed_file);
        }
        $data->signed_file = $document_path;
        $data->update();
        $this->iteration = rand();        
        $this->documentPath = $data->id;        
        $this->dispatchBrowserEvent('approve');
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'File uploaded successfully! ']);
    }

    public function approveSignedDoc()
    {

        DB::transaction(function () {
        $signed = DmSignatureRequestDocSignatory::Where(['document_id' => $this->active_document_id, 'signatory_id' => auth()->user()->id])->first();
        if ($signed) {
            $data = DmSignatureRequestDoc::where('id', $this->active_document_id)->first();

            if ($data->signed_file != null && $data->signed_file != $signed->signed_file) {
                Storage::disk($this->disk)->delete($data->signed_file);
            }
            $data->signed_file = $signed->signed_file;
            $data->update();
            $signed->status = 'Signed';
            $signed->signature = 'SN_'.GeneratorService::getNumber(8);
            $signed->update();
            $signatory = DmSignatureRequestDocSignatory::Where(['document_id' => $this->active_document_id, 'status' => 'Pending'])
                ->orderBy('signatory_level', 'asc')->first();
            if ($signatory) {
                $signatory->update(['status' => 'Active']);
            }
            $pendinSignatory =  DmSignatureRequestDocSignatory::where(['document_id' => $this->active_document_id])->where('status','!=','Signed')->first();
            // dd($pendinSignatory);
            if($pendinSignatory == null){
                // dd('done');
                $this->markDocumentComplete();
                $pendinRequest =  DmSignatureRequestDoc::where(['request_code' => $this->requestCode, 'signed_file'=>null])->where('status','!=','Signed')->first();
                if($pendinRequest == null){
                    // dd('done');
                $this->markRequestComplete();
                }
            }
            
           
        }
    });
        $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'File approved successfully! ']);

    }
    public function markDocumentComplete()
    {
       $data = DmSignatureRequestDoc::where('id', $this->active_document_id)->update(['status'=>'Signed']);
        try {
            $user = User::where('id',$data->created_by )->first();
           
            $signature_request = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'Document request has been fully signed',
                'greeting' => 'Dear '.$user->title.' '.$user->name,
                'body' => 'Your request #'.$data->title.' on request '.$data->request_code.' has been completed',
                'thanks' => 'Thank you, incase of any question, please reply to support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => url('/documents/request/'.$data->request_code.'/sign'),
                'department_id' => $data->created_by,
                'user_id' => $data->created_by,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
        //   $mm=  SendEmailNotification::dispatch($signature_request)->delay(Carbon::now()->addSeconds(20));
        //   dd($mms);
        } catch(Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'Success',  'message' => 'Document has been successfully marked complete! ']);
    }
    public function markRequestComplete()
    {
      $data =  DmSignatureRequest::where('request_code',$this->requestCode)->first();
      $data->status ='Completed';
      $data->update();
      DmSignatureRequestDoc::where('request_code', $this->requestCode)->update(['status'=>'Signed']);
        try {
            $user = User::where('id',$data->created_by )->first();
           
            $signature_request = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'Document request for '.$data->title.' Has been completed',
                'greeting' => 'Hi '.$user->title.' '.$user->name,
                'body' => 'Your request #'.$data->title.' on request '.$data->request_code.' has been completed',
                'thanks' => 'Thank you, incase of any question, please reply support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => url('/documents/request/'.$data->request_code.'/sign'),
                'department_id' => $data->created_by,
                'user_id' => $data->created_by,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
        //   $mm=  SendEmailNotification::dispatch($signature_request)->delay(Carbon::now()->addSeconds(20));
        //   dd($mms);
        } catch(Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'Success',  'message' => 'Document request has been successfully marked complete! ']);
    }

    public function rejectDocument()
    {
        $this->validate([

            'comments' => 'required|string',
        ]);

        $data = DmSignatureRequestDoc::where('id', $this->active_document_id)->first();
        $data->status = 'Rejected';
        $data->update();

        DmSignatureRequestDocSignatory::Where(['document_id' => $this->active_document_id, 'signatory_id' => auth()->user()->id])
            ->update(['status' => 'Rejected', 'comments' => $this->comments]);

        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Decument successfully rejected! ']);
    }

    public function resubmitDocument($id)
    {

        $data = DmSignatureRequestDoc::where(['id' => $id, 'created_by' => auth()->user()->id])->first();
        $data->status = 'Submitted';
        $data->update();

        $signatory = DmSignatureRequestDocSignatory::Where(['document_id' => $id, 'status' => 'Rejected'])
            ->orderBy('signatory_level', 'asc')->first();
        if ($signatory) {
            $signatory->update(['status' => 'Active']);
        }

        $otherSignatory = DmSignatureRequestDocSignatory::Where(['document_id' => $id, 'status' => 'Rejected'])->first();
        if ($otherSignatory) {
            $otherSignatory->update(['status' => 'Pending']);
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Decument successfully resubmitted! ']);
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


    public function downloadSignedDocument(DmSignatureRequestDoc $document)
    {
        
        $file = $document->signed_file;

        // Check if the file exists
        if (Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->download($document->signed_file, $document->title . ' signed');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
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

    public function render()
    {

        $data['requestData'] = $this->active_request = DmSignatureRequest::where('request_code', $this->requestCode)->with(['category', 'documents', 'user'])->first();

        $data['documents'] = DmSignatureRequestDoc::where('request_code', $this->requestCode)->with(['signatories', 'supportDocuments'])->get();
        $data['pending_documents'] =  DmSignatureRequestDoc::where('request_code', $this->requestCode)->where('status','!=','Signed')->count();
        $data['active_document'] = $data['documents']->only($this->active_document_id)[0];
        return view('livewire.documents.requests.dm-sign-request-sign-doc-component', $data);
    }
}
