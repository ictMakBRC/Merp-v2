<?php

namespace App\Http\Livewire\Finance\Requests;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsPaymentRequestDetail;
use App\Models\Finance\Requests\FmsPaymentRequestPosition;
use App\Models\Finance\Requests\FmsPaymentRequestPositions;
use App\Models\Finance\Requests\FmsPaymentRequestAttachment;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;

class FmsPaymentRequestDetailsComponent extends Component
{
    use WithFileUploads;
    public $requestCode;
    public $requestData;
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
    public $currency;

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
    public function updatedUnitCost()
    {
        $this->updatedQuantity();
    }
    public function updatedQuantity()
    {
        if ($this->quantity != "" && $this->unit_cost != '') {
            $this->amount = $this->unit_cost * $this->quantity;
           
        }
    }
    public function mount($code)
    {
        $this->requestCode = $code;

    }
    public function saveExpense($id)
    {
        $this->validate([
            'expenditure' => 'required',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
        ]);
        $amount = $this->quantity*$this->unit_cost;
        $requestItem = new FmsPaymentRequestDetail();
        $requestItem->request_id = $id;
        $requestItem->request_code = $this->requestCode;
        $requestItem->expenditure = $this->expenditure;
        $requestItem->quantity = $this->quantity;
        $requestItem->unit_cost = $this->unit_cost;
        $requestItem->amount = $amount;
        $requestItem->description = $this->description;
        $requestItem->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item created successfully!']);
    }
    public function saveAttachment($id)
    {
        $this->validate([
            'name' => 'required',
            'reference' => 'nullable|string',
            'file' => 'required|mimes:jpg,pdf,docx|max:10240|file|min:10', // 10MB Max
        ]);
        if ($this->file != null) {
            $name = date('Ymdhis').'_'.$this->requestCode.'.'.$this->file->extension();
            $path = date('Y').'/'.date('M').'/Payments/Requests/Attachments';
            $file = $this->file->storeAs($path, $name, $this->disk);
        }
        $requestItem = new FmsPaymentRequestAttachment();
        $requestItem->request_id = $id;
        $requestItem->request_code = $this->requestCode;
        $requestItem->name = $this->name;
        $requestItem->reference = $this->reference;
        $requestItem->file = $file;
        $requestItem->save();
        $this->iteration = rand();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment added successfully!']);
    }
    public function addSignatory($id)
    {
        $this->validate([
            'position' => 'required',
            'signatory_level' => 'required|integer',
            'approver_id' => 'required|integer',
        ]);
        $exists = FmsPaymentRequestAuthorization::where(['position' => $this->position, 'request_id' => $id])->first();
        // dd($exists);
        if ($exists) {
            $this->position_exists = true;
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Signatory already exists on this particular document, please select another different person']);
            return false;
        }
        $requestItem = new FmsPaymentRequestAuthorization();
        $requestItem->request_id = $id;
        $requestItem->request_code = $this->requestCode;
        $requestItem->position = $this->position;
        $requestItem->level = $this->signatory_level;
        $requestItem->approver_id = $this->approver_id;
        $requestItem->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment added successfully!']);
    }
    public function resetInputs()
    {
        $this->reset([
            'expenditure',
            'quantity',
            'unit_cost',
            'amount',
            'description',
            'name',
            'reference',
            'position',
            'signatory_level',
            'approver_id'
        ]);        
        $this->position_exists = false;
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
    function deleteFile($attachment) {
        $file = FmsPaymentRequestAttachment::where('id', $attachment)->first();
        if ($file) {
            if ($file->file != null) {
                Storage::disk($this->disk)->delete($file->file);
            }
        $file->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment deleted successfully!']);
        }else {
            $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'error',
                        'message' => 'Not Found!',
                        'text' => 'Attachment not found!',
                    ]);
        }
    }
    public function confirmDelete($budgetId)
    {
        $this->confirmingDelete = true;
        $this->itemToRemove = $budgetId;
    }

    public function submitRequest($id)
    {
        DB::transaction(function () use($id){
       $request = FmsPaymentRequest::where(['request_code'=> $this->requestCode, 'id'=>$id])->update(['status'=>'Submitted','date_submitted'=>date('Y-m-d')]);
    //    dd($request);
        $signatory = FmsPaymentRequestAuthorization::Where(['request_code'=> $this->requestCode, 'request_id'=>$id, 'status' => 'Pending'])
        ->orderBy('level', 'asc')->first();
    //    dd($signatory);
        $signatory->update(['status' => 'Active']);
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request submitted successfully!']);
        return redirect()->SignedRoute('finance-request_preview', $this->requestCode);
        });
    }
  

    public function deleteRecord()
    {

        FmsPaymentRequestDetail::find($this->itemToRemove)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item deleted successfully!']);
        $this->confirmingDelete = false;
        $this->itemToRemove = null;
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
        $data['positions'] = FmsPaymentRequestPosition::where('is_active', 1)
        ->when($requestData->requestable_type == 'App\Models\HumanResource\Settings\Department', function ($query) {
            $query->where('name_lock','!=', 'grants');
        })->get();
        $data['signatories'] = User::where('is_active', 1)->get();
        $level = FmsPaymentRequestAuthorization::where('request_id', $data['request_data']->id)->orderBy('id', 'DESC')->first();
        if ($level) {
            $this->signatory_level = $level->level + 1;
        } else {
            $this->signatory_level = 1;
        }
        $this->totalAmount = $data['items']->sum('amount');        
        $this->amountRemaining = $requestData->total_amount - $this->totalAmount;
        
        return view('livewire.finance.requests.fms-payment-request-details-component',$data);
    }
}
