<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Settings\FmsService;
use App\Models\Finance\Invoice\FmsInvoiceItem;
use App\Models\Finance\Settings\FmsUnitService;

class FmsInvoiceItemsComponent extends Component
{
    use WithFileUploads;
    public $invoiceCode;
    public $invoiceData;
    public $invoice_id;
    public $item_id;
    public $tax_id;
    public $quantity = 1;
    public $unit_price = 1;
    public $line_total;
    public $description;
    public $created_by;
    public $updated_by;
    public $currency;

    public $confirmingDelete = false;
    public $itemToRemove;
    public $subTotal = 0;
    public $totalAmount = 0;
    public $biller;
    public $billed;
    public $file_upload;
    public $adjustment = 0,$discount_type='Percent', $discount = 0,$discount_total = 0 ;
    public function updatedItemId()
    {
        $service = FmsService::where('id', $this->item_id)->first();
        $unit_price = $service->sale_price ?? 0;
        if($unit_price && $this->invoiceData->rate){
            $this->unit_price = $unit_price/$this->invoiceData->rate;
        }
        $this->description = $service->description ??null;
        if ($this->quantity != "" && $this->unit_price != '') {
            $this->line_total = $this->unit_price * $this->quantity;
        }
    }
    public function updatedQuantity()
    {
        if ($this->quantity != "" && $this->unit_price != '') {
            $this->line_total = $this->unit_price * $this->quantity;
        }
    }
    public function updatedUnitPrice()
    {
        if ($this->quantity != "" && $this->unit_price != '') {
            $this->line_total = $this->unit_price * $this->quantity;
        }
    }
    public function updatedDiscountType()
    {
        $this->updatedDiscount();
    }
    public function updatedDiscount()
    {
        if ($this->discount  ) {
            if($this->discount_type =='Fixed'){
                $this->discount_total = $this->discount;
            }  if($this->discount_type =='Percent' && $this->discount > 0){
                $this->discount_total =  ($this->discount/100)*$this->subTotal;
            }
            else{
                $this->discount_total = 0;
            }
            $this->totalAmount = $this->adjustment + $this->subTotal - $this->discount_total;
        }
    }
    public function updatedAdjustment()
    {
        if ($this->adjustment && $this->adjustment>=0 ) {
            $this->totalAmount = $this->adjustment + $this->subTotal - $this->discount_total;
        }
    }
    public function mount($inv_no)
    {
        $this->invoiceCode = $inv_no;

    }
    public $file_name;
    function saveAttachment() {
        $this->validate([
            'file_upload' => 'required|mimes:jpg,png,pdf,xlsx|max:10240|file|min:1',
            'file_name' => 'required|string',
        ]);
        // if ($this->file_upload) {
        //     $this->invoiceData->addMedia($this->file_upload)->toMediaCollection();
        //     $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice attachment uploaded successfully!']);
        // } 
        if ($this->file_upload) {
            // Generate a unique file name
            $fileName = Str::uuid()->toString() . '.' . $this->file_upload->getClientOriginalExtension();    
            // Specify the storage format
            $storageFormat = 'Finance'; // Example: 's3', 'local', 'public', etc.
    
            // Add the media with the specified name and storage format
            $media = $this->invoiceData->addMedia($this->file_upload)
                ->usingFileName($fileName) // Specify the file names
                ->toMediaCollection('invoice_attachments', $storageFormat); // Specify the collection name and storage format
            
            // Set custom name for the media
            $media->update(['name' => $this->file_name. '.' . $this->file_upload->getClientOriginalExtension()]);
    
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice attachment uploaded successfully!']);
        } 
    }
    public function downloadAttachment($mediaId)
    {
        // $media = $this->invoiceData->getFirstMedia();
        $media = FmsInvoice::findOrFail($mediaId)
        ->getFirstMedia('invoice_attachments');
        // dd($media);
        if ($media) {
            $path = $media->getPath(); // Get the path to the media file
    
            // Retrieve the original file name
            $fileName = $media->name;
            $disk = $media->disk;
    
            // Determine the MIME type based on the file extension
            $mimeType = Storage::disk($disk)->mimeType($path);
    
            // Set the appropriate content type header
            $headers = [
                'Content-Type' => $mimeType,
            ];
    
            // Return the file with the original file name and correct content type
            return response()->download($path, $fileName, $headers);
        } else {
            // Media not found, handle the situation
            abort(404, 'Media not found');
        }
    }
    public function saveItem($id)
    {
     
        if($this->invoiceData->invoice_type !='Incoming'){
            $this->validate([
                'item_id' => 'required|integer',
                'quantity' => 'required',
                'unit_price' => 'required',
                'description' => 'required',
            ]);
        }else{
            $this->validate([
                'item_id' => 'nullable|integer',
                'quantity' => 'required',
                'unit_price' => 'required',
                'description' => 'required',
            ]);
        }

        $invoiceItem = new FmsInvoiceItem();
        $invoiceItem->invoice_id = $id;
        $invoiceItem->item_id = $this->item_id;
        $invoiceItem->tax_id = $this->tax_id;
        $invoiceItem->quantity = $this->quantity;
        $invoiceItem->unit_price = $this->unit_price;
        $invoiceItem->line_total = $this->line_total;
        $invoiceItem->description = $this->description;
        $invoiceItem->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice item created successfully!']);
    }
    public function resetInputs()
    {
        $this->reset([
            'item_id',
            'tax_id',
            'quantity',
            'unit_price',
            'line_total',
            'description',
        ]);
    }
    public function confirmDelete($budgetId)
    {
        $this->confirmingDelete = true;
        $this->itemToRemove = $budgetId;
    }

    public function submitInvoice($id)
    {
       $invoice =  FmsInvoice::where(['invoice_no'=> $this->invoiceCode, 'id'=>$id])->first();
       if($invoice->status !='Pending'){
        $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'Invoice already submitted!']);
        return redirect()->SignedRoute('finance-invoice_view', $this->invoiceData->invoice_no);
       }else{
       $invoice->total_amount = $this->totalAmount;
       $invoice->amount_local = $this->totalAmount*$invoice->rate;
       $invoice->discount_type = $this->discount_type;
       $invoice->discount_total = $this->discount_total;
       $invoice->discount = $this->discount;
       $invoice->status = 'Submitted';
       $invoice->update();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice created successfully!']);
        return redirect()->SignedRoute('finance-invoice_view', $this->invoiceData->invoice_no);
       }
    }

    public function deleteRecord()
    {

        FmsInvoiceItem::find($this->itemToRemove)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice item deleted successfully!']);
        $this->confirmingDelete = false;
        $this->itemToRemove = null;
    }
    public function render()
    {
        $data['invoice_data'] = $invoiceData = FmsInvoice::where('invoice_no', $this->invoiceCode)->with(['department', 'project', 'customer', 'billedDepartment','billedProject', 'currency','bank','requestable','billtable'])->first();
        if ($invoiceData) {
            if($invoiceData->invoice_type =='External'){                
                $this->billed = $invoiceData->customer;
            }elseif($invoiceData->invoice_type =='Internal'){
                if($invoiceData->billed_department){
                    $this->billed = $invoiceData->billedDepartment;
                }elseif($invoiceData->billed_project){
                    $this->billed = $invoiceData->billedProject;
                }
            }
            if($invoiceData->department_id){
                $this->biller = $invoiceData->department;
            }elseif($invoiceData->project_id){
                $this->biller = $invoiceData->project;
            }
            $this->invoiceData = $invoiceData;
            // $this->currency = $invoiceData->currency->code??'UG';
            $data['items'] = FmsInvoiceItem::where('invoice_id', $data['invoice_data']->id)->with(['uintService','uintService.service'])->get();
        } else {
            $data['items'] = collect([]);
        }
        $this->subTotal = $data['items']->sum('line_total');
        $this->totalAmount = $this->adjustment + $this->subTotal - $this->discount_total;
        $data['services'] = FmsUnitService::where('is_active', 1)->with('service')->where(['unitable_type'=>$invoiceData->requestable_type, 'unitable_id'=>$invoiceData->requestable_id])->get();
        return view('livewire.finance.invoice.fms-invoice-items-component', $data);
    }
}
