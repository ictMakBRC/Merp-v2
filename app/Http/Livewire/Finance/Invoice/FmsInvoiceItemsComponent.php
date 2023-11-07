<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Invoice\FmsInvoiceItem;
use App\Models\Finance\Settings\FmsService;
use Livewire\Component;

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
    public $totalAmount = 0;
    public $biller;
    public $billed;
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
        FmsInvoice::where(['invoice_no'=> $this->invoiceCode, 'id'=>$id])->update(['status'=>'Submitted','total_amount'=>$this->totalAmount]);
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
            $data['items'] = FmsInvoiceItem::where('invoice_id', $data['invoice_data']->id)->with(['service'])->get();
        } else {
            $data['items'] = collect([]);
        }
        $this->totalAmount = $data['items']->sum('line_total');
        $data['services'] = FmsService::where('is_active', 1)->get();
        return view('livewire.finance.invoice.fms-invoice-items-component', $data);
    }
}
