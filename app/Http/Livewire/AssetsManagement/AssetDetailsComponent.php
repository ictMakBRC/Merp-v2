<?php

namespace App\Http\Livewire\AssetsManagement;

use Response;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Data\Assets\AssetLogData;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Assets\AssetsCatalog;
use App\Models\Grants\Project\Project;
use App\Models\Documents\FormalDocument;
use App\Services\Assets\AssetLogService;
use App\Data\Document\FormalDocumentData;
use App\Models\Documents\Settings\DmCategory;
use App\Models\HumanResource\Settings\Station;
use App\Services\Document\FormalDocumentService;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\Procurement\Request\ProcurementRequest;

class AssetDetailsComponent extends Component
{
    use WithFileUploads;
    public $activeTab='breakdown';
    public $asset_catalog_id;

    public $log_type;
    public $date_allocated;
    public $station_id;
    public $department_id;
    public $employee_id;
    public $allocation_status;

    public $breakdown_number;
    public $breakdown_type;
    public $breakdown_date;
    public $breakdown_description;
    public $action_taken;
    public $date_breakdown_recorded;
    public $breakdown_status;

    public $asset_breakdown_id;
    public $service_type;
    public $date_serviced;
    public $service_action;
    public $service_recommendations;
    public $resolution_status;
    public $serviced_by;
    public $cost;
    public $currency_id;
    public $next_service_date;

      //SUPPORT DOCUMENTS
      public $document_category;
      public $expires=0;
      public $expiry_date=null;
      public $document_name;
      public $document;
      public $document_path;
      public $description;

      public $assetCode='';

    public function mount($id){
        $this->asset_catalog_id=$id;
    }

    public function storeLogDetails()
    {
        $assetLogDTO = new AssetLogData();
        $assetLogService = new AssetLogService();

        if ($this->department_id) {
            $assetableModel = Department::findOrFail($this->department_id);
        } else {
            $assetableModel = Project::findOrFail($this->project_id);
        }

        if ($this->log_type=='Allocation') {
            $this->validate($assetLogDTO->allocationRules());
         
            DB::transaction(function () use($assetLogService,$assetableModel){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'date_allocated' => $this->date_allocated,
                    'station_id' => $this->station_id,
                    'employee_id' => $this->employee_id,
                    'allocation_status' => true,
                    
                    ]
                );
        
                $asset = $assetLogService->createAssetLog($assetableModel,$assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Allocation details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }elseif($this->log_type=='Breakdown'){
            // dd($assetLogDTO->resetInputs());
            $this->validate($assetLogDTO->breakdownRules());
            DB::transaction(function ()use($assetLogService,$assetableModel){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'breakdown_number' => GeneratorService::assetBreakdownNumber($this->asset_catalog_id),
                    'breakdown_type' => $this->breakdown_type,
                    'breakdown_date' => $this->breakdown_date,
                    'breakdown_description' => $this->breakdown_description,
                    'action_taken' => $this->action_taken,
                    'breakdown_status' => $this->breakdown_status,
                    
                    ]
                );
                // dd($assetLogDTO);
    
                $asset = $assetLogService->createAssetLog($assetableModel,$assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Breakdown details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }elseif($this->log_type=='Maintenance'){
            $this->validate($assetLogDTO->maintenanceRules());
            DB::transaction(function ()use($assetLogService,$assetableModel){

                $assetLogDTO = AssetLogData::from([
                    'asset_catalog_id' => $this->asset_catalog_id,
                    'log_type' => $this->log_type,
                    'asset_breakdown_id' => $this->asset_breakdown_id,
                    'service_type' => $this->service_type,
                    'date_serviced' => $this->date_serviced,
                    'service_action' => $this->service_action,
                    'service_recommendations' => $this->service_recommendations,
                    'resolution_status'=>$this->resolution_status,
                    'serviced_by' => $this->serviced_by,
                    'cost' => $this->cost,
                    'currency_id' => $this->currency_id,
                    'next_service_date' => $this->next_service_date,
                    
                    ]
                );
    
                $asset = $assetLogService->createAssetLog($assetableModel,$assetLogDTO);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset Maintenance details created successfully']);
                $this->reset($assetLogDTO->resetInputs());
    
            });

        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Log type has been selected for this operation!',
            ]);
            return;
        }

        
    }


    public function storeDocument()
    {
        if ($this->asset_catalog_id==null) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops Not Found!',
                'text' => 'No Asset has been selected for this operation!',
            ]);
            return;
        }

        $formalDocumentDTO = new FormalDocumentData();
        $this->validate($formalDocumentDTO->rules());

        DB::transaction(function (){
            $asset = AssetsCatalog::findOrFail($this->asset_catalog_id);

            if ($this->document != null) {
                $this->validate([
                    'document' => ['mimes:pdf', 'max:10000'],
                ]);
    
                $documentName = date('YmdHis').$asset->asset_name.' '.$this->document_category.'.'.$this->document->extension();
                $this->document_path = $this->document->storeAs('assets_management_documents', $documentName);
            } else {
                $this->document_path = null;
            }
            
            $formalDocumentDTO = FormalDocumentData::from([
                'document_category'=>$this->document_category,
                'expires'=>$this->expires,
                'expiry_date'=>$this->expiry_date,
                'document_name'=>$this->document_name,
                'document_path'=>$this->document_path,
                'description'=>$this->description,

                ]
            );
  
            $formalDocumentService = new FormalDocumentService();
            $document = $formalDocumentService->createFormalDocument($asset,$formalDocumentDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Document created successfully']);

            $this->reset($formalDocumentDTO->resetInputs());

        });
    }

    public function downloadDocument(FormalDocument $formalDocument)
    {
        $file = storage_path('app/').$formalDocument->document_path;
        $path_parts = pathinfo($file);
        $filename = $formalDocument->document_name.'.'.$path_parts['extension'];

        if (file_exists($file)) {
            return Response::download($file, $filename);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Document not found!',
            ]);
        }
    }
    
    public function render()
    {
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        $data['employees'] = Employee::where('is_active',true)->get();
        $data['document_categories'] = DmCategory::all();

        $data['asset']=AssetsCatalog::with('category','category.classification','logs','documents')->findOrFail($this->asset_catalog_id);

        
        
        return view('livewire.assets-management.asset-details-component',$data)->layout('layouts.app');
    }
}
