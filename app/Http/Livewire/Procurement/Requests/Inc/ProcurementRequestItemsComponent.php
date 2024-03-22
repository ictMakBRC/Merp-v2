<?php

namespace App\Http\Livewire\Procurement\Requests\Inc;

use App\Models\Procurement\Request\ProcurementRequest;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Request\ProcurementRequestItem;

class ProcurementRequestItemsComponent extends Component
{
    public $procurement_request_id;
    public $item_name;
    public $description;
    public float $quantity=0;
    public $unit_of_measure;
    public float $estimated_unit_cost=0;
    public $total_cost;

    public $procurementRequest;

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

        $budgetLineBalance=getBudgetLineBalance($this->procurementRequest->budget_line_id);

        if ($this->procurementRequest->request_type == 'Department') {
            $ledgerBalance=getLedger($this->procurementRequest->request_type,auth()->user()->employee->department->id)->current_balance;
        } else {
            $ledgerBalance=getLedger($this->procurementRequest->request_type,$this->procurementRequest->requestable_id)->current_balance;
        }

        $totalContractValue = ($this->procurementRequest->contract_value + $this->total_cost);

        if (($totalContractValue > $ledgerBalance) || ($totalContractValue > $budgetLineBalance)) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Insufficient funds',
                'text' => 'Total value/cost of items exceeds available funds!',
            ]);
            return;
        }

        $this->validate([
            'item_name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'unit_of_measure' => 'required|string',
            'estimated_unit_cost' => 'required|numeric',
            'total_cost' => 'required|numeric',
        ]);

        DB::transaction(function (){

            $procurementRequestItem = ProcurementRequestItem::create([
                'procurement_request_id' => $this->procurement_request_id,
                'item_name' => $this->item_name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'unit_of_measure' => $this->unit_of_measure,
                'estimated_unit_cost' => $this->estimated_unit_cost,
                'total_cost' => $this->total_cost,

                ]
            );

            // $this->procurementRequest=ProcurementRequest::findOrFail($this->procurement_request_id);
            $this->procurementRequest->increment('contract_value',$this->total_cost);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item created successfully']);

            $this->reset([
                'item_name',
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
        DB::transaction(function () use($procurementRequestItem){
            $procurementRequestItem->delete();
            $procurementRequest = ProcurementRequest::findOrFail($this->procurement_request_id);
            $procurementRequest->decrement(['contract_value',intVal($procurementRequestItem->total_cost)]);
        });
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item deleted successfully']);
    }

    public function render()
    {
        if($this->procurement_request_id){

        $request = ProcurementRequest::with('items')->findOrFail($this->procurement_request_id)??null;
        $this->procurementRequest = $request;
        $data['items'] = $request?->items??collect([]);

        }else{
            $data['items'] = collect([]);
        }

        return view('livewire.procurement.requests.inc.procurement-request-items-component',$data);
    }
}
