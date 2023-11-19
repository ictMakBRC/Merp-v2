<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestItem;
use App\Services\GeneratorService;

class BidderPricesComponent extends Component
{
    public $request_id;
    public $request;
    public $item_id;
 
    public float $bidder_unit_cost;
    public ?float $bidder_total_cost;
 

    public $items_list;
    public $remainingItem;

    public function mount(){
        $this->items_list=collect([]);
    }

    public function updatedBidderUnitCost(){

        $this->bidder_total_cost = (ProcurementRequestItem::findOrFail($this->item_id)->quantity)*$this->bidder_unit_cost;
    }

    public function activateItem(ProcurementRequestItem $procurementRequestItem)
    {
        $this->bidder_unit_cost=0;
        $this->bidder_total_cost=0;
        // $this->resetInputs();
        $this->item_id = $procurementRequestItem->id;
    }

    public function storeBidderPrice(ProcurementRequestItem $procurementRequestItem){
        $this->validate([
            'bidder_unit_cost'=>'required|numeric|gt:0',
            'bidder_total_cost'=>'required|numeric|gt:0',
        ]);

        // dd('YES');
        if($this->item_id){
            DB::transaction(function () use($procurementRequestItem) {
                
                $procurementRequestItem->update([
                    'bidder_unit_cost'=>$this->bidder_unit_cost,
                    'bidder_total_cost'=>$this->bidder_total_cost,
                ]);

                $item = $this->items_list->where('id','!=',$procurementRequestItem->id)->first();
                $this->remainingItem=$item;
                if($item){
                    $this->item_id = $item->id;
                }else{
                    $this->request->update([
                        'contract_value'=>getItemsTotalCost($this->request_id),
                    ]);
                }
            });

            $this->bidder_unit_cost=0;
            $this->bidder_total_cost=0;
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item price updated successfully']);

            if (!$this->remainingItem) {
                $this->request->update([
                    'lpo_no'=>GeneratorService::localPurchaseOrderNo(),
                ]);

                if (requiresProcurementContract($this->request->contract_value)) {
                
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Macro Procurement!',
                        'text' => 'You will need to issue a contract to the provider!',
                    ]);

                }else{
                    $this->redirect(route('proc-lpo', $this->request->id)); 
                }
                
            }
        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'No item selected for this operation!',
            ]);
        }
        
    }

    public function resetInputs(){
        $this->reset(['bidder_unit_cost','bidder_total_cost']);
    }

    public function render()
    {
        $this->request= ProcurementRequest::with('items')->findOrFail($this->request_id);
        
        $this->items_list = $this->request->items->where('bidder_unit_cost',null);

        return view('livewire.procurement.requests.procurement.inc.bidder-prices-component');
    }
}
