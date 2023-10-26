<?php

namespace App\Http\Livewire\Procurement\Requests\Stores\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Documents\Settings\DmCategory;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestItem;

class ProcurementItemsReceptionComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $item_id;
    public $quantity_requested;

    public $received_status;
    public $quantity_delivered;
    public $quality;
    public $comment;

    public $items_list;

    public function mount(){
        $this->items_list=collect([]);
    }

    public function activateItem(ProcurementRequestItem $procurementRequestItem)
    {
        $this->resetInputs();
        $this->quantity_requested=$procurementRequestItem->quantity;
        $this->item_id = $procurementRequestItem->id;
    }

    public function storeItemReceptionInformation(ProcurementRequestItem $procurementRequestItem){
        $this->validate([
            'received_status'=>'required|boolean',
            'quantity_delivered'=>'required|numeric|gt:0|lte:'.$this->quantity_requested,
            'quality'=>'required|string',
            'comment'=>'nullable|string',
        ]);

        if($this->item_id){
            $procurementRequestItem->update([
                'received_status'=>$this->received_status,
                'quantity_delivered'=>$this->quantity_delivered,
                'quality'=>$this->quality,
                'comment'=>$this->comment,
                'received_by'=>auth()->user()->id,
            ]);

            $item = $this->items_list->where('id','!=',$procurementRequestItem->id)->first();
            if($item){
                $this->item_id = $item->id;
                $this->quantity_requested = $item->quantity;
            }
    
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item received successfully']);
        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'No item selected for this operation!',
            ]);
        }
    }

    public function resetInputs(){
        $this->reset(['received_status','quantity_delivered','quality','comment']);
    }

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers')->findOrFail($this->request_id);
        
        $this->items_list = $data['request']->items->where('received_status',false);

        $data['document_categories'] = DmCategory::all();

        return view('livewire.procurement.requests.stores.inc.procurement-items-reception-component',$data);
    }
}
