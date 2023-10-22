<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Documents\Settings\DmCategory;
use App\Models\Procurement\Settings\Provider;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\SelectedProvider;
use App\Models\Procurement\Settings\ProcurementMethod;

class RequestBiddingComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $procurement_category;
    public $request;

    public $search;

    //Contracts Committee Decision
    public $decision;
    public $procurement_method_id;
    public $report;
    public $report_path;

    public $evaluation_report;
    public $evaluation_report_path;

    public $provider_id;
    public $providerIds=[];
    public $selectedProviders;

    public function mount(){
        $request = ProcurementRequest::findOrFail($this->request_id);
        $this->procurement_category=$request->procurement_sector;
        $this->request = $request;
        $this->selectedProviders = collect([]);
    }

    public function updatedProviderIds()
    {

        $this->selectedProviders = Provider::whereHas('procurementSubcategories', function ($query) {
            $query->where(['category' => $this->procurement_category]);
        })->whereIn('id', $this->providerIds)->get();
     
    }

    public function attachProviders()
    {
            $this->validate([
                'selectedProviders' => 'required',
            ]);

            $this->request->providers()->sync($this->providerIds);
            SelectedProvider::where('procurement_request_id',$this->request_id)->update([
                'created_by' => auth()->id(),
            ]);
   
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Providers attached successfully']);
    }

    public function detachProvider($providerId)
    {
       
        $this->providerIds = array_values(array_diff($this->providerIds,[$providerId]));
        $this->selectedProviders = Provider::whereHas('procurementSubcategories', function ($query) {
            $query->where(['category' => $this->procurement_category]);
        })->whereIn('id', $this->providerIds)->get();
        
        // $this->request->providers()->detach($providerId);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Providers detached successfully']);

    }

    public function saveProcurementMethodDecision(){
       
    }

    public function saveEvaluationDecision(){
       
    }


    public function resetInputs()
    {
        // $this->reset(['provider_id']);
        $this->providerIds = [];
        $this->selectedProviders = collect([]);
    }

    public function filterProviders()
    {
        $providers = Provider::search($this->search)->whereHas('procurementSubcategories', function ($query) {
            $query->where(['category' => $this->procurement_category]);
        })->get();

        return $providers;
    }

    public function render()
    {
        $data['procurementMethods'] = ProcurementMethod::all();
        $data['providers'] =$this->filterProviders();

        $data['document_categories'] = DmCategory::all();

        return view('livewire.procurement.requests.procurement.inc.request-bidding-component',$data);
    }
}
