<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Invoice\FmsInvoiceItem;

class FmsViewInvoiceComponent extends Component
{
    public $invoiceCode;
    public $currency;
    public function mount($inv_no)
    {
        $this->invoiceCode = $inv_no;

    }
    public function render()
    {
        $data['invoice_data'] = $invoiceData = FmsInvoice::where('invoice_no', $this->invoiceCode)->with(['department', 'project', 'customer', 'biller', 'currency'])->first();
        if ($invoiceData) {
            $this->currency = $invoiceData->currency->code??'UG';
            $data['items'] = FmsInvoiceItem::where('invoice_id', $data['invoice_data']->id)->with(['service'])->get();
        } else {
            $data['items'] = collect([]);
        }
        return view('livewire.finance.invoice.fms-view-invoice-component', $data);
    }
}
