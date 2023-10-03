<?php

namespace App\Http\Livewire\Finance\Requests;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsPaymentRequestDetail;
use App\Models\Finance\Requests\FmsPaymentRequestAttachment;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;

class FmsPaymentPreviewComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $request_code;
    public $expenditure;
    public $quantity = 1;
    public $unit_cost = 1;
    public $amount;
    public $amountRemaining;
    public $description;
    public $created_by;
    public $updated_by;

    public $name;
    public $reference;
    public $file;
    public $disk = 'Finance';
    public $iteration;

    public $position;
    public $approver_id;
    public $position_exists = false;

    public $signatory_level;

    public $confirmingDelete = false;
    public $itemToRemove;
    public $totalAmount = 0;
    public $currency;
    public $requestData;
    public $requestCode;
    public function mount($code)
    {
        $this->requestCode = $code;

    }
    public function downloadAttachment(FmsPaymentRequestAttachment $attachment)
    {

        $file = $attachment->file;       

        // Check if the file exists
        if (Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->download($file, $attachment->request_code.'_Attachment');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment successfully downloaded!']);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'error',
                        'message' => 'Not Found!',
                        'text' => 'Attachment not found!',
                    ]);
        }

        
    }

    function approve($id) {
        
    }
    
    public function render()
    {
        $data['request_data'] = $requestData = FmsPaymentRequest::where('request_code', $this->requestCode)->with(['department', 'project','currency','requestable','budgetLine'])->first();
        if ($requestData) {
            $this->requestData = $requestData;
            $this->currency = $requestData->currency->code??'UG';
            $data['items'] = FmsPaymentRequestDetail::where('request_id', $data['request_data']->id)->get();
            $data['attachments'] = FmsPaymentRequestAttachment::where('request_id', $data['request_data']->id)->get();
            $data['authorizations'] = FmsPaymentRequestAuthorization::where('request_id', $data['request_data']->id)->with(['authPosition','user','approver'])->get();
        } else {
            $data['items'] = collect([]);
            $data['attachments'] =collect([]);
            $data['authorizations'] =collect([]);
        }
        $this->totalAmount = $data['items']->sum('amount');        
        return view('livewire.finance.requests.fms-payment-preview-component',$data);
    }
}
