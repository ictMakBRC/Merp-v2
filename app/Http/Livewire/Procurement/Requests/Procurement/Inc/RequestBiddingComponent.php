<?php

namespace App\Http\Livewire\Procurement\Requests\Procurement\Inc;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Data\Document\FormalDocumentData;
use App\Enums\ProcurementRequestEnum;
use App\Models\Documents\Settings\DmCategory;
use App\Models\Procurement\Settings\Provider;
use App\Services\Document\FormalDocumentService;
use App\Models\Procurement\Request\SelectedProvider;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestDecision;
use App\Models\Procurement\Settings\ProcurementMethod;

class RequestBiddingComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $procurement_category;
    public $isMacroProcurement=false;
    public $request;

    public $search;

    //Contracts Committee Decision
    public $decision;
    public $decision_date;
    public $procurement_method_id;
    public $bid_return_deadline;
    public $report;
    public $report_path;
    public $document_category;
    public $comment;

    public $provider_id;
    public $providerIds=[];
    public $selectedProviders;
    public $subcategory_id;

    //Evaluation
    public $best_bidder_id;
    public $invoice_no;
    public $invoice_date;
    public $delivery_deadline;
    public $bidder_contract_price;
    public $net_payment_terms;
 
    public function mount(){
        $request = ProcurementRequest::findOrFail($this->request_id);
        $this->procurement_category = $request->procurement_sector;
        $this->request = $request;
        $this->subcategory_id = $request->subcategory_id;
        $this->selectedProviders = collect([]);

        $this->isMacroProcurement=isMacroProcurement($request->contract_value);
    }

    public function updatedProviderIds()
    {
        $this->selectedProviders = Provider::whereIn('id', $this->providerIds)->get();
    }

    public function attachProviders()
    {
            $this->validate([
                'selectedProviders' => 'required',
            ]);

            $this->request->providers()->sync($this->providerIds);
            // SelectedProvider::where('procurement_request_id',$this->request_id)->update([
            //     'created_by' => auth()->id(),
            // ]);
   
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
        if ($this->isMacroProcurement) {
            $this->validate([
                'decision'=>'required|string',
                'decision_date'=>'required|date|before_or_equal:today',
                'procurement_method_id'=>'required|integer',
                'bid_return_deadline'=>'required_if:decision,Approved',
                'comment'=>'required|string',
                
            ]);
           DB::transaction(function () {
                ProcurementRequestDecision::create([
                    'procurement_request_id'=>$this->request->id,
                    'decision_maker'=>ProcurementRequestEnum::CC,
                    'decision'=>$this->decision,
                    'step'=>ProcurementRequestEnum::PM_APPROVAL,
                    'comment'=>$this->comment,
                    'decision_date'=>$this->decision_date,
                ]);
    
                $this->request->update([
                    'procurement_method_id'=>$this->procurement_method_id,
                    'bid_return_deadline'=>$this->bid_return_deadline,
                    'status'=>$this->decision==ProcurementRequestEnum::APPROVED ? ProcurementRequestEnum::PROCESSING:$this->decision,
    
                ]);
    
                $this->storeDocument('Procurement Method Report');
                $this->attachProviders();
                $this->sendRequestForQuotation($this->request,$this->selectedProviders);
           });

        }else{
            $this->validate([
                'procurement_method_id'=>'required|integer',
                'bid_return_deadline'=>'required|date|after_or_equal:today',
                'comment'=>'required|string',
                
            ]);

           DB::transaction(function () {
                ProcurementRequestDecision::create([
                    'procurement_request_id'=>$this->request->id,
                    'decision_maker'=>ProcurementRequestEnum::PD,
                    'decision'=>ProcurementRequestEnum::APPROVED,
                    'step'=>ProcurementRequestEnum::PM_APPROVAL,
                    'comment'=>$this->comment,
                    'decision_date'=>today(),
                ]);
    
                $this->request->update([
                    'procurement_method_id'=>$this->procurement_method_id,
                    'bid_return_deadline'=>$this->bid_return_deadline,
                    'status'=>$this->decision==ProcurementRequestEnum::APPROVED ? ProcurementRequestEnum::PROCESSING:$this->decision,
    
                ]);

                $this->attachProviders();
           });
        }
        
       $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Method approval information saved successfully']);
    }

    public function saveEvaluationDecision(){
        if ($this->isMacroProcurement) {
            $this->validate([
                'decision'=>'required|string',
                'best_bidder_id'=>'required|integer',
                'invoice_no'=>'required_if:decision,Approved|string',
                'invoice_date'=>'required_if:decision,Approved|date|before_or_equal:today',
                'delivery_deadline'=>'required_if:decision,Approved|date|after_or_equal:today',
                'net_payment_terms'=>'required_if:decision,Approved|integer',
                'bidder_contract_price'=>'required_if:decision,Rejected|numeric',
                'decision_date'=>'required|date|before_or_equal:today',
                'comment'=>'required|string',
                
            ]);

            DB::transaction(function () {
                ProcurementRequestDecision::create([
                    'procurement_request_id'=>$this->request->id,
                    'decision_maker'=>ProcurementRequestEnum::CC,
                    'decision'=>$this->decision,
                    'step'=>ProcurementRequestEnum::ER_APPROVAL,
                    'comment'=>$this->comment,
                    'decision_date'=>$this->decision_date,
                ]);
                
                $this->request->providers()->updateExistingPivot($this->best_bidder_id, [
                    'is_best_bidder'=>true,
                    'invoice_no'=>$this->invoice_no,
                    'invoice_date'=>$this->invoice_date,
                    'bidder_contract_price'=>$this->bidder_contract_price,
                ]);

                $this->request->update([
                    'delivery_deadline' => $this->delivery_deadline,
                    'net_payment_terms' => $this->net_payment_terms,
                    'status'=>$this->decision==ProcurementRequestEnum::APPROVED ? ProcurementRequestEnum::PROCESSING:$this->decision,
                    
                ]);

                $this->storeDocument('Procurement Evaluation Report');
            });
        }else{
            $this->validate([
                'decision'=>'required|string',
                'best_bidder_id'=>'required|integer',
                'invoice_no'=>'required_if:decision,Approved|string',
                'invoice_date'=>'required_if:decision,Approved|date|before_or_equal:today',
                'delivery_deadline'=>'required_if:decision,Approved|date|after_or_equal:today',
                'net_payment_terms'=>'required_if:decision,Approved|integer',
                'bidder_contract_price'=>'required_if:decision,Rejected',
                'comment'=>'required|string',
                
            ]);
  
           DB::transaction(function () {
                ProcurementRequestDecision::create([
                    'procurement_request_id'=>$this->request->id,
                    'decision_maker'=>ProcurementRequestEnum::PD,
                    'decision'=>$this->decision,
                    'step'=>ProcurementRequestEnum::ER_APPROVAL,
                    'comment'=>$this->comment,
                    'decision_date'=>today(),
                ]);
                
                $this->request->providers()->updateExistingPivot($this->best_bidder_id, [
                    'is_best_bidder'=>true,
                    'invoice_no'=>$this->invoice_no,
                    'invoice_date'=>$this->invoice_date,
                    'bidder_contract_price'=>$this->bidder_contract_price,
                ]);
    
                $this->request->update([
                    'delivery_deadline' => $this->delivery_deadline,
                    'net_payment_terms' => $this->net_payment_terms,
                    'status'=>$this->decision==ProcurementRequestEnum::APPROVED ? ProcurementRequestEnum::PROCESSING:$this->decision,

                ]);
           });
        }
        $this->resetInputs();
       $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Evaluation approval information saved successfully']);
    }

    public function storeDocument($docName){
        if ($this->report != null) {
            $this->validate([
                'report' => ['mimes:pdf', 'max:10000'],
                'document_category' => 'required|string',
            ]);

            $reportName = date('YmdHis').$this->request->reference_no.' '.$this->document_category.'.'.$this->report->extension();
            $this->report_path = $this->report->storeAs('procurement_request_documents', $reportName);
        } else {
            $this->report_path = null;
        }
        
        $formalDocumentDTO = FormalDocumentData::from([
            'document_category'=>$this->document_category,
            'expires'=>false,
            'expiry_date'=>null,
            'document_name'=>$docName,
            'document_path'=>$this->report_path,
            'description'=>$docName,

            ]
        );

        $formalDocumentService = new FormalDocumentService();
        $document = $formalDocumentService->createFormalDocument($this->request,$formalDocumentDTO);
    }

    public function resetInputs()
    {
        $this->reset([
            'decision',
            'decision_date',
            'procurement_method_id',
            'bid_return_deadline',
            'report',
            'report_path',
            'document_category',
            'comment',
            'best_bidder_id',
            'bidder_contract_price',
            'delivery_deadline',
            // 'bidder_revised_price',
        ]);

        $this->providerIds = [];
        $this->selectedProviders = collect([]);
    }

    public function filterProviders()
    {
        $providers = Provider::search($this->search)->whereHas('procurementSubcategories', function ($query) {
            $query->where(['subcategory_id' => $this->subcategory_id]);
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
