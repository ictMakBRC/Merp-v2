<?php

namespace App\Data\Assets;

use Spatie\LaravelData\Data;

class AssetCatalogData extends Data
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
    public ?string $currency;
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
   

    // Validation rules for the properties
    public function rules(): array
    {
        return [
            'asset_categories_id' => 'required|integer',
            'asset_name' => 'required|string',
            'serial_number' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255|unique:asset_catalog',
            'engraved_label' => 'nullable|string|max:255',
            'asset_condition' => 'required|string',
            'description'=>'nullable|string',
            'acquisition_type'=>'required|string',
            'project_id'=>'nullable|integer',
            'procurement_date'=>'nullable|date|before_or_equal:today',
            'procurement_type'=>'nullable|string',
            'invoice_number'=>'nullable|string',
            'cost'=>'nullable|numeric',
            'currency'=>'nullable|string',
            'supplier_id'=>'nullable|integer',
            'has_service_contract'=>'required|integer',
            'service_contract_expiry_date'=>'nullable|date|after_or_equal:today',
            'service_provider'=>'nullable|int',
            'warranty_details'=>'nullable|string',
            'useful_years'=>'nullable|integer',
            'depreciation_method'=>'required|string',
            'salvage_value'=>'nullable|numeric',
            'operational_status'=>'required|integer',

        ];
    }
    
    // Validation rules for the properties
    public function resetInputs(): array
    {
        return array_keys($this->rules());
    }
}
