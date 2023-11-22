<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use App\Jobs\Procurement\SendLpo;
use App\Models\Procurement\Request\ProcurementRequest;

class LpoComponent extends Component
{
    public $request_id;

    public function mount($id){
        $this->request_id=$id;
    }

    public function sendLocalPurchaseOrder(ProcurementRequest $procurementRequest)
    {
        try {
            SendLpo::dispatch($procurementRequest);
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'LPO sent',
                'text' => 'LPO been sent successfully',
            ]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Sending failed!',
                'text' => 'Something went wrong and LPO could not be sent. Please try again.',
            ]);
        }
    }
    
    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','approvals','approvals.approver','bestBidders')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.procurement.inc.lpo-component',$data);
    }
}
