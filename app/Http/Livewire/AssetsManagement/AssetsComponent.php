<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Data\Assets\AssetCatalogData;
use App\Services\Assets\AssetCatalogService;
use App\Models\HumanResource\Settings\Station;
use App\Models\HumanResource\Settings\Department;

class AssetsComponent extends Component
{
    public ?int $asset_categories_id;
    public ?string $asset_name;
    public ?string $brand;
    public ?string $model;
    public ?string $serial_number;
    public ?string $barcode;
    public ?string $engraved_label;
    public ?string $description;
    public ?string $acquisition_type;
    public ?string $project_id;
    public ?string $procurement_date;
    public ?string $procurement_type;
    public ?string $invoice_number;
    public ?float $cost;
    public ?int $supplier_id;
    public ?bool $has_service_contract;
    public ?string $service_contract_expiry_date;
    public ?int $service_provider;
    public ?string $warranty_details;
    public ?float $useful_years;
    public ?string $depreciation_method;
    public ?float $salvage_value;
    public ?string $asset_condition;
    public ?int $operational_status;

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

    public function render()
    {
        $data['stations'] = Station::where('is_active',true)->get();
        $data['departments'] = Department::where('is_active',true)->get();
        return view('livewire.assets-management.assets-component',$data)->layout('layouts.app');
    }
}
