<?php

namespace App\Services\Assets;

use App\Models\Assets\AssetsCatalog;
use App\Data\Assets\AssetCatalogData;
use Illuminate\Database\Eloquent\Model;

class AssetCatalogService
{
    public function createAsset(Model $model,AssetCatalogData $assetCatalogDTO):AssetsCatalog
    {
        $assetCatalog = $model->assets()->create([
            ...$this->fillAssetFromDTO($assetCatalogDTO)
        ]);
        
        return $assetCatalog;
    }

    public function updateAsset(AssetsCatalog $assetCatalog, AssetCatalogData $assetCatalogDTO):AssetsCatalog
    {
        
        $assetCatalog->update([
            ...$this->fillAssetFromDTO($assetCatalogDTO)
        ]);

        return $assetCatalog;
    }

    private function fillAssetFromDTO(AssetCatalogData $assetCatalogDTO)
    {
        return [
                'entry_type' => $assetCatalogDTO->entry_type,
                'asset_category_id' => $assetCatalogDTO->asset_category_id,
                'asset_name' => $assetCatalogDTO->asset_name,
                'brand' => $assetCatalogDTO->brand,
                'model' => $assetCatalogDTO->model,
                'serial_number' => $assetCatalogDTO->serial_number,
                'barcode' => $assetCatalogDTO->barcode,
                'engraved_label' => $assetCatalogDTO->engraved_label,
                'description' => $assetCatalogDTO->description,
                'acquisition_type' => $assetCatalogDTO->acquisition_type,
                'procurement_request_id' => $assetCatalogDTO->procurement_request_id,
                'procurement_date' => $assetCatalogDTO->procurement_date,
                'invoice_number' => $assetCatalogDTO->invoice_number,
                'cost' => $assetCatalogDTO->cost,
                'currency_id' => $assetCatalogDTO->currency_id,
                'supplier_id' => $assetCatalogDTO->supplier_id,
                'has_service_contract' => $assetCatalogDTO->has_service_contract,
                'service_contract_expiry_date' => $assetCatalogDTO->service_contract_expiry_date,
                'service_provider' => $assetCatalogDTO->service_provider,
                'warranty_details' => $assetCatalogDTO->warranty_details,
                'useful_years' => $assetCatalogDTO->useful_years,
                'depreciation_method' => $assetCatalogDTO->depreciation_method,
                'salvage_value' => $assetCatalogDTO->salvage_value,
                'asset_condition' => $assetCatalogDTO->asset_condition,
                'operational_status' => $assetCatalogDTO->operational_status,
        ];
    }
}
