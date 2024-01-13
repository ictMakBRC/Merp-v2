<?php

namespace App\Services\Assets;

use App\Models\Assets\AssetsCatalog;
use App\Data\Assets\AssetCatalogData;

class AssetCatalogService
{
    public function createAsset(AssetCatalogData $assetCatalogDTO):AssetsCatalog
    {
        $assetCatalog = new AssetsCatalog();
        $this->fillAssetFromDTO($assetCatalog, $assetCatalogDTO);
        $assetCatalog->save();

        return $assetCatalog;
    }

    public function updateAsset(AssetsCatalog $assetCatalog, AssetCatalogData $assetCatalogDTO):AssetsCatalog
    {
        $this->fillAssetFromDTO($assetCatalog, $assetCatalogDTO);
        $assetCatalog->save();

        return $assetCatalog;
    }

    private function fillAssetFromDTO(AssetsCatalog $assetCatalog, AssetCatalogData $assetCatalogDTO)
    {
        $assetCatalog->asset_categories_id = $assetCatalogDTO->asset_categories_id;
        $assetCatalog->asset_name = $assetCatalogDTO->asset_name;
        $assetCatalog->brand = $assetCatalogDTO->brand;
        $assetCatalog->model = $assetCatalogDTO->model;
        $assetCatalog->serial_number = $assetCatalogDTO->serial_number;
        $assetCatalog->barcode = $assetCatalogDTO->barcode;
        $assetCatalog->engraved_label = $assetCatalogDTO->engraved_label;
        $assetCatalog->description = $assetCatalogDTO->description;
        $assetCatalog->acquisition_type = $assetCatalogDTO->acquisition_type;
        $assetCatalog->project_id = $assetCatalogDTO->project_id;
        $assetCatalog->procurement_date = $assetCatalogDTO->procurement_date;
        $assetCatalog->procurement_type = $assetCatalogDTO->procurement_type;
        $assetCatalog->invoice_number = $assetCatalogDTO->invoice_number;
        $assetCatalog->cost = $assetCatalogDTO->cost;
        $assetCatalog->currency_id = $assetCatalogDTO->currency_id;
        $assetCatalog->supplier_id = $assetCatalogDTO->supplier_id;
        $assetCatalog->has_service_contract = $assetCatalogDTO->has_service_contract;
        $assetCatalog->service_contract_expiry_date = $assetCatalogDTO->service_contract_expiry_date;
        $assetCatalog->service_provider = $assetCatalogDTO->service_provider;
        $assetCatalog->warranty_details = $assetCatalogDTO->warranty_details;
        $assetCatalog->useful_years = $assetCatalogDTO->useful_years;
        $assetCatalog->depreciation_method = $assetCatalogDTO->depreciation_method;
        $assetCatalog->salvage_value = $assetCatalogDTO->salvage_value;
        $assetCatalog->asset_condition = $assetCatalogDTO->asset_condition;
        $assetCatalog->operational_status = $assetCatalogDTO->operational_status;
    }
}
