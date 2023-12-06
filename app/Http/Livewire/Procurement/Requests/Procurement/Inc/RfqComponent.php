<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use App\Jobs\Procurement\SendRfq;
use App\Models\Procurement\Request\ProcurementRequest;

class RfqComponent extends Component
{
    public $request_id;

    public function mount($id){
        $this->request_id=$id;
    }


    public function sendRequestForQuotation(ProcurementRequest $procurementRequest)
    {
        try {
            SendRfq::dispatch($procurementRequest);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'RFQ sent',
                'text' => 'RFQ been sent successfully',
            ]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Sending failed!',
                'text' => 'Something went wrong and RFQ could not be sent. Please try again.'.$th->getMessage(),
            ]);
        }
    }
    
    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','approvals','approvals.approver','providers')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.procurement.inc.rfq-component',$data);
    }
}
