<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Settings\ProcurementCategorization;

class ProcurementCategorizationComponent extends Component
{
    use WithPagination;
    public $categorization;
    public $threshold;
    public $contract_requirement_threshold;
    public $currency_id;
    public $description;
    

    public $createNew = false;
    public $toggleForm = false;
    public $readonly = false;

    public $categorizationsCount=0;

    public $procurementCategorization;

    public function mount(){
        $this->currency_id=getDefaultCurrency()->id;
    }

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatedCategorization()
    {
        $categorizations = ProcurementCategorization::latest()->get();
        $this->categorizationsCount=$categorizations->count();
        if($this->categorizationsCount==1){
            $categorization=$categorizations->first();
            $this->currency_id = $categorization->currency_id;

            if($categorization->categorization=='Micro' && $this->categorization!='Micro'){
                $this->threshold = $categorization->threshold+0.01;
                $this->readonly = true;
            }elseif($categorization->categorization=='Macro' && $this->categorization!='Macro'){
                $this->threshold = $categorization->threshold-0.01;
                $this->readonly = true;
            }else{
                $this->readonly = true;
            }
        }
    }
  

    public function storeCategorization(){
        
        if($this->categorizationsCount==2){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Operation Failed!',
                'text' => 'There can only be procurement categorization',
            ]);
            return;
        }

        $this->validate([
            'categorization' => 'required|string|unique:procurement_categorizations',
            'threshold' => 'required|numeric',
            'contract_requirement_threshold' => 'nullable|required_if:categorization,Macro|numeric|gte:threshold',
            'currency_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $categorization = ProcurementCategorization::create([
            'categorization' => $this->categorization,
            'threshold' => $this->threshold,
            'contract_requirement_threshold' => $this->contract_requirement_threshold,
            'currency_id' => $this->currency_id,
            'description' => $this->description,

            ]
        );

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Categorization created successfully']);

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
    }

    public function editData(ProcurementCategorization $procurementCategorization)
    {
        $this->procurementCategorization = $procurementCategorization;

        $this->categorization = $procurementCategorization->categorization;
        $this->threshold = $procurementCategorization->threshold;
        $this->contract_requirement_threshold = $procurementCategorization->contract_requirement_threshold;
        $this->currency_id = $procurementCategorization->currency_id;
        $this->description = $procurementCategorization->description;
        
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateCategorization()
    {
        $this->validate([
            'categorization' => 'required|string|unique:procurement_categorizations,categorization,'. $this->procurementCategorization->id,
            'threshold' => 'required|numeric',
            'contract_requirement_threshold' => 'nullable|required_if:categorization,Macro|numeric|gte:threshold',
            'currency_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);



        try {
            DB::transaction(function () {
 
                $this->procurementCategorization->update([
                    'categorization' => $this->categorization,
                    'threshold' => $this->threshold,
                    'contract_requirement_threshold' => $this->contract_requirement_threshold,
                    'currency_id' => $this->currency_id,
                    'description' => $this->description,
        
                    ]
                );

                if(ProcurementCategorization::count()==2){

                    if($this->procurementCategorization->categorization=='Micro'){
                        ProcurementCategorization::where('id','!=',$this->procurementCategorization->id)->update(['threshold'=>$this->threshold+0.01]);
                    }else{
                        ProcurementCategorization::where('id','!=',$this->procurementCategorization->id)->update(['threshold'=>$this->threshold-0.01]);
                    }
                }

                $this->resetInputs();
                $this->createNew = false;
                $this->toggleForm = false;
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Categorization Information updated successfully,']);
            });
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Operation Failed!',
                'text' => 'Something went wrong and the operation could not be completed. Please try again',
            ]);
        }
    }

    public function resetInputs(){
        $this->reset([
            'categorization',
            'threshold',
            'contract_requirement_threshold',
            'description',
        ]);
    }


    public function render()
    {
        $data['categorizations'] = ProcurementCategorization::with('currency')->get();
        return view('livewire.procurement.settings.procurement-categorization-component',$data);
    }
}
