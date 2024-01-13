<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Settings\FmsService;
use App\Models\Finance\Invoice\FmsInvoiceItem;
use App\Models\Finance\Settings\FmsUnitService;

class FmsInvoiceItemsComponent extends Component
{
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
    public $adjustment = 0,$discount_type='Percent', $discount = 0,$discount_total = 0 ;
    public function updatedItemId()
    {
        $service = FmsService::where('id', $this->item_id)->first();
        $this->unit_price = $service->sale_price ?? 0;
        $this->description = $service->description ?? 'N/A';
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
    public function saveItem($id)
    {
        $this->validate([
            'item_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

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
       $invoice->total_amount = $this->totalAmount;
       $invoice->discount_type = $this->discount_type;
       $invoice->discount_total = $this->discount_total;
       $invoice->discount = $this->discount;
       $invoice->status = 'Submitted';
       $invoice->update();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice created successfully!']);
        return redirect()->SignedRoute('finance-invoice_view', $this->invoiceData->invoice_no);
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
        $data['invoice_data'] = $invoiceData = FmsInvoice::where('invoice_no', $this->invoiceCode)->with(['department', 'project', 'customer', 'billedDepartment','billedProject', 'currency'])->first();
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
            $this->currency = $invoiceData->currency->code??'UG';
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
