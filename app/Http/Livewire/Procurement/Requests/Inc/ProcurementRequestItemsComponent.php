<?php

namespace App\Http\Livewire\Procurement\Requests\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Request\ProcurementRequestItem;

class ProcurementRequestItemsComponent extends Component
{
    public $procurement_request_id;
    public $description;
    public $quantity=0;
    public $unit_of_measure;
    public $estimated_unit_cost=0;
    public $total_cost;

    public $loadingInfo;

    protected $listeners = [
        'procurementRequestCreated' => 'setprocurementRequestId',
        'loadProcurementRequest',
    ];

    public function setprocurementRequestId($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];
    }

    public function loadProcurementRequest($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];
        $this->render();

    }

    public function updatedEstimatedUnitCost($details)
    {
       if ($this->quantity) {
        $this->total_cost = $this->quantity * $this->estimated_unit_cost;
       }
    }

    public function storeItem()
    {
        if ($this->procurement_request_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Procurement Request has been selected for this operation!',
            ]);
            return;
        }

        $this->validate([
            // 'procurement_request_id' => 'required|integer',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'unit_of_measure' => 'required|string',
            'estimated_unit_cost' => 'required|numeric',
            'total_cost' => 'required|numeric',
        ]);

        DB::transaction(function (){

            $procurementRequestItem = ProcurementRequestItem::create([
                'procurement_request_id' => $this->procurement_request_id,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'unit_of_measure' => $this->unit_of_measure,
                'estimated_unit_cost' => $this->estimated_unit_cost,
                'total_cost' => $this->total_cost,

                ]
            );

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item created successfully']);

            $this->reset([
                // 'procurement_request_id',
                'description',
                'quantity',
                'unit_of_measure',
                'estimated_unit_cost',
                'total_cost',
            ]);

        });
    }

    public function deleteItem(ProcurementRequestItem $procurementRequestItem)
    {
        $procurementRequestItem->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item deleted successfully']);
    }

    public function render()
    {
        $data['items'] = ProcurementRequestItem::where('procurement_request_id',$this->procurement_request_id)->get()??collect([]);
        return view('livewire.procurement.requests.inc.procurement-request-items-component',$data);
    }
}
