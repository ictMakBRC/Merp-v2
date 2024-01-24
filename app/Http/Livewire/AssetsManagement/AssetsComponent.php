<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Data\Assets\AssetLogData;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use App\Models\Assets\AssetsCatalog;
use App\Data\Assets\AssetCatalogData;
use App\Models\Grants\Project\Project;
use Illuminate\Database\Eloquent\Model;
use App\Services\Assets\AssetLogService;
use App\Services\Assets\AssetCatalogService;
use App\Models\Assets\Settings\AssetCategory;
use App\Models\Procurement\Settings\Provider;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\Procurement\Request\ProcurementRequest;

class AssetsComponent extends Component
{
    use WithPagination;

    public $entry_type;
    public $station_id;
    public $department_id;
    public $project_id;
    public $employee_id;

    public $procurement_request_id;

    public $asset_category_id;
    public $asset_name;
    public $brand;
    public $model;
    public $serial_number;
    public $barcode;
    public $engraved_label;
    public $description;
    public $acquisition_type;
    // public $project_id;
    public $procurement_date;
    public $procurement_type;
    public $invoice_number;
    public $cost;
    public $currency_id;
    public $supplier_id;
    public $has_service_contract;
    public $service_contract_expiry_date;
    public $service_provider;
    public $warranty_details;
    public $useful_years;
    public $depreciation_method;
    public $salvage_value;
    public $asset_condition;
    public $operational_status;

     //Filters

     public $user_category;

     public $from_date;
 
     public $to_date;
 
     public $user_status;
 
     public $assetIds;
 
     public $perPage = 50;
 
     public $search = '';
 
     public $orderBy = 'id';
 
     public $orderAsc = 0;

     protected $paginationTheme = 'bootstrap';

     public $createNew = false;
 
     public $toggleForm = false;
 
     public $filter = false;

     public $asset;
     public $asset_id;

     public function updatedAssetId()
     {
         if ($this->asset_id) {
             $this->emit('logAsset', [
                 'assetId' => $this->asset_id,
             ]);
         }else{
             $this->emit('logAsset', [
                 'assetId' => null,
             ]);
         }
     }

     public function updatedCreateNew()
     {
         $this->resetInputs();
         $this->toggleForm = false;
     }
 
     public function updatingSearch()
     {
         $this->resetPage();
     }
 
     protected $validationAttributes = [
         'is_active' => 'status',
     ];

    public function storeAsset()
    {
        $assetCatalogDTO = new AssetCatalogData();
        $this->validate($assetCatalogDTO->rules());

        DB::transaction(function (){

            if ($this->entry_type == 'Department') {
                // dd('TRUE');
                $assetableModel = Department::findOrFail($this->department_id);
                $assetableModelCode=$assetableModel->prefix;

            } else {
                $assetableModel = Project::findOrFail($this->project_id);
                $assetableModelCode=$assetableModel->project_code;
            }

            $assetCatalogDTO = AssetCatalogData::from([
                'entry_type' => $this->entry_type,
                'asset_category_id' => $this->asset_category_id,
                'asset_name' => GeneratorService::assetLabel(str_replace(' ', '-', $assetableModelCode),$this->asset_category_id),
                'brand' => $this->brand,
                'model' => $this->model,
                'serial_number' => $this->serial_number,
                'barcode' => $this->barcode,
                'engraved_label' => $this->engraved_label,
                'description' => $this->description,
                'acquisition_type' => $this->acquisition_type,
                'procurement_request_id' => $this->procurement_request_id,
                'procurement_date' => $this->procurement_date,
                // 'procurement_type' => $this->procurement_type,
                'invoice_number' => $this->invoice_number,
                'cost' => $this->cost,
                'currency_id' => $this->currency_id,
                'supplier_id' => $this->supplier_id,
                'has_service_contract' => $this->has_service_contract,
                'service_contract_expiry_date' => $this->service_contract_expiry_date,
                'service_provider' => $this->service_provider,
                'warranty_details' => $this->warranty_details,
                'useful_years' => $this->useful_years,
                'depreciation_method' => $this->depreciation_method,
                'salvage_value' => $this->salvage_value,
                'asset_condition' => $this->asset_condition,
                'operational_status' => $this->operational_status,
                
                ]
            );
  
            $assetCatalogService = new AssetCatalogService();

            $asset = $assetCatalogService->createAsset($assetableModel,$assetCatalogDTO);
            
            $this->storeLogDetails($assetableModel,$asset->id);
            // dd('YES');
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset created and added to catalog successfully']);

            $this->reset($assetCatalogDTO->resetInputs());

        });
    }

    public function storeLogDetails(Model $model,$assetId)
    {
        $assetLogDTO = new AssetLogData();
        $assetLogService = new AssetLogService();
        // $this->validate($assetLogDTO->allocationRules());
        
        $assetLogDTO = AssetLogData::from([
            'asset_catalog_id' => $assetId,
            'log_type' => 'Allocation',
            'date_allocated' => today(),
            'station_id' => $this->station_id,
            'employee_id' => $this->employee_id,
            'allocation_status' => true,
            
            ]
        );

        $asset = $assetLogService->createAssetLog($model,$assetLogDTO);
        
    }

    public function editData(AssetsCatalog $assetCatalog)
    {
        $this->asset = $assetCatalog;
        $this->asset_category_id = $assetCatalog->asset_category_id;
        $this->asset_name = $assetCatalog->asset_name;
        $this->brand = $assetCatalog->brand;
        $this->model = $assetCatalog->model;
        $this->serial_number = $assetCatalog->serial_number;
        $this->barcode = $assetCatalog->barcode;
        $this->engraved_label = $assetCatalog->engraved_label;
        $this->description = $assetCatalog->description;
        $this->acquisition_type = $assetCatalog->acquisition_type;
        $this->project_id = $assetCatalog->project_id;
        $this->procurement_date = $assetCatalog->procurement_date;
        $this->procurement_type = $assetCatalog->procurement_type;
        $this->invoice_number = $assetCatalog->invoice_number;
        $this->cost = $assetCatalog->cost;
        $this->currency_id = $assetCatalog->currency_id;
        $this->supplier_id = $assetCatalog->supplier_id;
        $this->has_service_contract = $assetCatalog->has_service_contract;
        $this->service_contract_expiry_date = $assetCatalog->service_contract_expiry_date;
        $this->service_provider = $assetCatalog->service_provider;
        $this->warranty_details = $assetCatalog->warranty_details;
        $this->useful_years = $assetCatalog->useful_years;
        $this->depreciation_method = $assetCatalog->depreciation_method;
        $this->salvage_value = $assetCatalog->salvage_value;
        $this->asset_condition = $assetCatalog->asset_condition;
        $this->operational_status = $assetCatalog->operational_status;
       
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateAsset()
    {
        $assetCatalogDTO = new AssetCatalogData();
        $this->validate($assetCatalogDTO->rules());

        DB::transaction(function (){

            $assetCatalogDTO = AssetCatalogData::from([
                'asset_category_id' => $this-> asset_category_id,
                'asset_name' => $this->asset_name,
                'brand' => $this->brand,
                'model' => $this->model,
                'serial_number' => $this->serial_number,
                'barcode' => $this->barcode,
                'engraved_label' => $this->engraved_label,
                'description' => $this->description,
                'acquisition_type' => $this->acquisition_type,
                'project_id' => $this->project_id,
                'procurement_date' => $this->procurement_date,
                'procurement_type' => $this->procurement_type,
                'invoice_number' => $this->invoice_number,
                'cost' => $this->cost,
                'currency_id' => $this->currency_id,
                'supplier_id' => $this->supplier_id,
                'has_service_contract' => $this->has_service_contract,
                'service_contract_expiry_date' => $this->service_contract_expiry_date,
                'service_provider' => $this->service_provider,
                'warranty_details' => $this->warranty_details,
                'useful_years' => $this->useful_years,
                'depreciation_method' => $this->depreciation_method,
                'salvage_value' => $this->salvage_value,
                'asset_condition' => $this->asset_condition,
                'operational_status' => $this->operational_status,
                
                ]
            );
  
            $assetCatalogService = new AssetCatalogService();

            $asset = $assetCatalogService->updateAsset($this->asset,$assetCatalogDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset catalogue updated successfully']);

            $this->reset($assetCatalogDTO->resetInputs());
            $this->createNew = false;
            $this->toggleForm = false;

        });
    }

    public function filterAssets()
    {
        $assets = AssetsCatalog::search($this->search)
            
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->assetIds = $assets->pluck('id')->toArray();

        return $assets;
    }

    public function resetInputs()
    {
        $this->reset();
    }

    public function render()
    {
        $data['categories'] = AssetCategory::with('classification')->get();
        $data['departments'] = Department::where('is_active',true)->get();
        $data['projects'] = Project::all();
        $data['employees'] = Employee::where('is_active',true)->get();
        $data['procurement_requests'] = ProcurementRequest::get();
        $data['providers'] = Provider::where('is_active',true)->get();
        $data['stations'] = Station::where('is_active',true)->get();

        $data['assets'] = $this->filterAssets()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.assets-management.assets-component',$data)->layout('layouts.app');
    }
}
