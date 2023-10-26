<?php

namespace App\Http\Livewire\Procurement\Requests\ContractsManager\Inc;

use Livewire\Component;
use App\Models\Procurement\Settings\Provider;
use App\Models\Procurement\Request\ProcurementRequest;

class RequestManagementComponent extends Component
{
    public $request_id;

    public $provider_id;
    public $quality_rating=1;
    public $timeliness_rating=1;
    public $cost_rating=1;
    public $comment;

    public function storeRatings(ProcurementRequest $procurementRequest){

        $provider_id = $procurementRequest->providers->where('pivot.is_best_bidder', true)->first()->id;
 
        $this->validate([
            'quality_rating'=>'required|numeric|gt:0|lte:5',
            'cost_rating'=>'required|numeric|gt:0|lte:5',
            'timeliness_rating'=>'required|numeric|gt:0|lte:5',
            'comment'=>'required|string',
        ]);

        $procurementRequest->providers()->updateExistingPivot($provider_id, [
            'quality_rating'=>$this->quality_rating,
            'cost_rating'=>$this->cost_rating,
            'timeliness_rating'=>$this->timeliness_rating,
            'average_rating'=> round(($this->quality_rating+$this->timeliness_rating+$this->cost_rating)/3,1),
            'contracts_manager_comment'=>$this->comment,
        ]);

        $this->resetInputs();
    }

    public function resetInputs(){
        $this->reset(['quality_rating','timeliness_rating','cost_rating','comment']);
    }

    public function render()
    {
        $data['request'] = ProcurementRequest::with('bestBidders')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.contracts-manager.inc.request-management-component',$data);
    }
}
