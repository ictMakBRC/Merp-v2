<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use App\Models\Procurement\Request\ProcurementRequest;
use Livewire\Component;
use App\Models\Procurement\Settings\Provider;
use App\Models\Procurement\Settings\ProcurementMethod;
use Livewire\WithFileUploads;

class CcDecisionComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $procurement_category;

    //CC DECISION
    public $cc_decision;
    public $procurement_method_id;
    public $provider_id;
    public $committee_report;
    public $committee_report_path;

    public function mount(){
        $request = ProcurementRequest::findOrFail($this->request_id);
        $this->procurement_category=$request->procurement_sector;
    }

    public function render()
    {
        $data['procurementMethods'] = ProcurementMethod::all();
        $data['providers'] = Provider::whereHas('procurementSubcategories', function ($query) {
            $query->where(['category' => $this->procurement_category]);
        })->get();

        return view('livewire.procurement.requests.procurement.inc.cc-decision-component',$data);
    }
}
