<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use App\Models\Procurement\Request\ProcurementRequest;

class LpoComponent extends Component
{
    public $request_id;

    public function mount($id){
        $this->request_id=$id;
    }
    
    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','approvals','approvals.approver','bestBidders')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.procurement.inc.lpo-component',$data);
    }
}
