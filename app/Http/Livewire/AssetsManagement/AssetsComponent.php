<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Assets\AssetsCatalog;
use App\Data\Assets\AssetCatalogData;
use App\Services\Assets\AssetCatalogService;
use App\Models\Assets\Settings\AssetCategory;
use App\Models\HumanResource\Settings\Department;

class AssetsComponent extends Component
{
    use WithPagination;

    public $asset_categories_id;
    public $asset_name;
    public $brand;
    public $model;
    public $serial_number;
    public $barcode;
    public $engraved_label;
    public $description;
    public $acquisition_type;
    public $project_id;
    public $procurement_date;
    public $procurement_type;
    public $invoice_number;
    public $cost;
    public $currency;
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

            $assetCatalogDTO = AssetCatalogData::from([
                'asset_categories_id' => $this-> asset_categories_id,
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
                'currency' => $this->currency,
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

            $asset = $assetCatalogService->createAsset($assetCatalogDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Asset created and added to catalog successfully']);

            $this->reset($assetCatalogDTO->resetInputs());

        });
    }

    public function editData(AssetsCatalog $assetCatalog)
    {
        $this->asset = $assetCatalog;
        $this->asset_categories_id = $assetCatalog->asset_categories_id;
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
        $this->currency = $assetCatalog->currency;
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
                'asset_categories_id' => $this-> asset_categories_id,
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
                'currency' => $this->currency,
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
        $data['assets'] = $this->filterAssets()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.assets-management.assets-component',$data)->layout('layouts.app');
    }
}
